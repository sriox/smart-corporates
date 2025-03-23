<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\Company\AgeRange;
use App\Models\Company\Area;
use App\Models\Company\Company;
use App\Models\Company\CompanyLevel;
use App\Models\Company\Division;
use App\Models\Company\Gender;
use App\Models\Company\Participant;
use App\Models\Company\ServiceTimeRange;
use App\Models\Operations\ParticipantOpenQuestionAnswer;
use App\Models\Operations\ParticipantPollAnswer;
use App\Models\Operations\ParticipantWords;
use App\Models\Poll\OpenQuestion;
use App\Models\Poll\Poll;
use App\Models\Poll\PollAnswer;
use App\Models\Poll\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function submit($code)
    {
        $participant = Participant::where('code', $code)->first();
        if (!$participant) return Inertia::render('Feedback/ParticipantNotValid');

        $poll = Poll::find($participant->pollInstance->poll_id);
        $company = Company::find($participant->pollInstance->company_id);
        if ($participant->finish_at) return Inertia::render('Operations/PollSubmitFinished', compact('code', 'company', 'poll'));

        $areas = Area::where('company_id', $company->id)->orderBy('name')->get();
        $ageRanges = AgeRange::where('company_id', $company->id)->get();
        $divisions = Division::whereHas('area', function ($query) use ($company) {
            return $query->where('company_id', $company->id);
        })
            ->orderBy('name', 'asc')
            ->get();
        $genders = Gender::where('company_id', $company->id)->get();
        $serviceTimeRanges = ServiceTimeRange::where('company_id', $company->id)->get();
        $companyLevels = CompanyLevel::where('company_id', $company->id)->get();

        return Inertia::render('Operations/SubmitPoll', compact('code', 'poll', 'company', 'areas', 'ageRanges', 'divisions', 'genders', 'serviceTimeRanges', 'companyLevels', 'participant'));
    }

    public function submitDemographicInfo($code, Request $request)
    {
        $participant = Participant::where('code', $code)->first();
        $participant->update([
            'age_range_id' => $request->ageRangeId,
            'gender_id' => $request->genderId,
            'service_time_range_id' => $request->serviceTimeRangeId,
            'company_level_id' => $request->companyLevelId,
            'area_id' => $request->areaId,
            'division_id' => $request->divisionId,
            'start_at' => now()
        ]);

        return redirect(route('questions.show', ['code' => $code]));
    }

    public function pollQuestions($code)
    {
        $page = request('page', 1);
        $participant = Participant::with('participantPollAnswers')->where('code', $code)->first();
        $poll = Poll::find($participant->pollInstance->poll_id);
        $company = Company::find($participant->pollInstance->company_id);
        if (!$participant) return Inertia::render('Feedback/ParticipantNotValid');
        $questions = Question::where('poll_id', $participant->pollInstance->poll_id)->paginate(20);
        $answers = PollAnswer::where('poll_id', $participant->pollInstance->poll_id)->orderBy('value')->get();

        return Inertia::render('Operations/SubmitPollQuestions', compact('participant', 'questions', 'answers', 'code', 'page', 'company', 'poll'));
    }

    public function storeAnswers($code, Request $request)
    {
        $request->validate([
            'page' => 'required|numeric',
            'lastPage' => 'required',
            'pollAnswers' => 'required|array'
        ]);

        $participant = Participant::where('code', $code)->first();

        $answers = [];
        foreach ($request->pollAnswers as $answer) {
            $answers[] = [
                'participant_id' => $participant->id,
                'question_id' => $answer['questionId'],
                'poll_answer_id' => $answer['answerId'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questionIds = array_pluck($request->pollAnswers, 'questionId');

        $participant->participantPollAnswers()->whereIn('question_id', $questionIds)->delete();

        $result = ParticipantPollAnswer::insert($answers);

        if (!$request->lastPage) {
            $page = $request->page + 1;
            return redirect()->route('questions.show', ['code' => $code, 'page' => $page]);
        }

        if ($participant->pollInstance->poll->openQuestions->count() === 0) {
            return redirect('submit.finish', ['code' => $code]);
        }

        return redirect()->route('openQuestions.show', ['code' => $code]);
    }

    public function showOpenQuestions($code)
    {
        $participant = Participant::where('code', $code)->first();
        $poll = Poll::find($participant->pollInstance->poll_id);
        $company = Company::find($participant->pollInstance->company_id);
        $pollQuestionsCount = Question::where('poll_id', $participant->pollInstance->poll_id)->count();

        $openQuestions = OpenQuestion::where('poll_id', $participant->pollInstance->poll_id)->get();

        return Inertia::render('Operations/OpenQuestions', compact('code', 'openQuestions', 'poll', 'company', 'pollQuestionsCount'));
    }

    public function storeOpenQuestions($code, Request $request)
    {
        $request->validate([
            'answers' => 'required|array|min:1'
        ]);

        $participant = Participant::where('code', $code)->first();

        $openQuestionAnswers = [];
        $words = [];
        foreach ($request->answers as $answer) {
            $openQuestionAnswers[] = [
                'participant_id' => $participant->id,
                'open_question_id' => $answer['questionId'],
                'answer' => $answer['answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($answer['questionType'] === 'words') {
                $newWords = $this->processWords($participant->id, $answer['questionId'], $answer['answer']);
                $words = array_merge($words, $newWords);
            }
        }
        ParticipantOpenQuestionAnswer::insert($openQuestionAnswers);
        ParticipantWords::insert($words);

        return redirect()->route('submit.finish', ['code' => $code]);
    }

    private function processWords($participantId, $questionId, $answer)
    {
        $remove = ['el', 'la', 'las', 'por', 'para', 'pa', 'a', 'durante', 'segun', 'ante', 'en', 'sin', 'bajo', 'entre', 'so', 'cabe', 'hacia', 'sobre', 'con', 'hasta', 'tras', 'contra', 'mediante', 'versus', 'de', 'via', 'desde', 'que', 'pues'];

        $words = array_filter(array_map(function ($word) {
            return mb_strtolower(trim($word));
        }, explode(',', $answer)), function ($word) use ($remove) {
            return !in_array($word, $remove);
        });

        $list = [];
        foreach ($words as $word) {
            $list[] = [
                'participant_id' => $participantId,
                'open_question_id' => $questionId,
                'word' => $word,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        return $list;
    }

    public function finishSubmit($code)
    {
        $participant = Participant::where('code', $code)->first();
        $participant->update([
            'finish_at' => now()
        ]);

        $company = Company::find($participant->pollInstance->company_id);
        $poll = Poll::find($participant->pollInstance->poll_id);

        return Inertia::render('Operations/PollSubmitFinished', compact('code', 'company', 'poll'));
    }
}
