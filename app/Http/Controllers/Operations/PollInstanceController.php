<?php

namespace App\Http\Controllers\Operations;

use App\Exports\DemographicsExport;
use App\Exports\DemographicsMap;
use App\Http\Controllers\Controller;
use App\Jobs\Operations\SendPollInvitations;
use App\Jobs\SendPariticipantReminder;
use App\Models\Company\AgeRange;
use App\Models\Company\Area;
use App\Models\Company\Company;
use App\Models\Company\CompanyLevel;
use App\Models\Company\Division;
use App\Models\Company\Gender;
use App\Models\Company\Participant;
use App\Models\Company\Person;
use App\Models\Company\ServiceTimeRange;
use App\Models\Operations\ParticipantPollAnswer;
use App\Models\Operations\PollInstance;
use App\Models\Poll\Dimension;
use App\Models\Poll\Poll;
use App\Models\Poll\PollAnswer;
use App\Models\Poll\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PollInstanceController extends Controller
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
        //
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

    public function participantsIndex(PollInstance $pollInstance)
    {
        $people = Person::withCount(['participants as participants_count' => function ($query) use ($pollInstance) {
            return $query->where('poll_instance_id', $pollInstance->id);
        }])
            ->withCount(['participants as completed_count' => function ($query) use ($pollInstance) {
                return $query->where('poll_instance_id', $pollInstance->id)
                    ->whereNotNull('finish_at');
            }])
            ->with('participants', function ($query) use ($pollInstance) {
                return $query
                    ->with('latestState:id,event,participant_mail_logs.participant_id,valid')
                    ->where('poll_instance_id', $pollInstance->id);
            })
            ->where('company_id', $pollInstance->company_id)->get();
        return Inertia::render('Operations/PollInstanceParticipants', compact('pollInstance', 'people'));
    }

    public function sendInvitations(PollInstance $pollInstance, Request $request)
    {
        $request->validate([
            'selectedPeople' => 'required|array|min:1'
        ]);

        $chunks = array_chunk($request->selectedPeople, 50);
        foreach ($chunks as $people) {
            foreach ($people as $person) {
                SendPollInvitations::dispatch($pollInstance, [$person]);
            }
        }

        return ['status' => 1, 'invitations' => count($request->selectedPeople)];
    }

    public function showReport(PollInstance $pollInstance)
    {
        $pollInstance->load(['poll', 'company']);

        return Inertia::render('Operations/PollInstanceReport', compact('pollInstance'));
    }

    public function getPollResults($id)
    {
        $pollResults = ParticipantPollAnswer::with('pollAnswer:id,value', 'question.questionGroup')->whereHas('participant', function ($query) use ($id) {
            return $query->where('poll_instance_id', $id)->whereNotNull('finish_at');
        })->get();
        return $pollResults;
    }

    public function getGeneralResult($id)
    {
        $maxAnswer = PollAnswer::orderBy('value', 'desc')->first()->value;
        $nAnswers = DB::table('v_results')->count();
        $factor = $maxAnswer * $nAnswers;
        $sum = DB::table('v_results')->sum('poll_answer_value');
        $result = $factor ? $sum / $factor * 100 : 0;
        return $result;
    }

    public function getEngageResult($id)
    {
        $maxAnswer = PollAnswer::orderBy('value', 'desc')->first()->value;
        $nAnswers = DB::table('v_results')->where('question_group', 'engagement')->count();
        $factor = $maxAnswer * $nAnswers;
        $sum = DB::table('v_results')->where('question_group', 'engagement')->sum('poll_answer_value');
        $result = $factor ? $sum / $factor * 100 : 0;

        return $result;
    }

    /**
     * Este es el resultado de todas las preguntas que no corresponden al grupo engagement
     * para poder calcular el resultado ponderado que corresponde a este indicador x 70%
     * más el resultado de engagement * 30%
     */
    public function getPonderatedResult($id)
    {
        $maxAnswer = PollAnswer::orderBy('value', 'desc')->first()->value;
        $indicators = DB::table('v_results')->whereNull('question_group')->sum('poll_answer_value');
        $engagement = DB::table('v_results')->where('question_group', 'engagement')->sum('poll_answer_value');
        $indicatorsFactor = $maxAnswer * DB::table('v_results')->whereNull('question_group')->count();
        $engagementFactor = $maxAnswer * DB::table('v_results')->where('question_group', 'engagement')->count();
        $indicatorsResult = $indicators / $indicatorsFactor * 100;
        $engagementResult = $engagement / $engagementFactor * 100;
        $result = ($indicatorsResult * 0.7) + ($engagementResult * 0.3);
        $result = $result;

        return $result;
    }

    public function getEmployeeNetPromoteResult($id)
    {

        $pro = DB::table('v_results')->where('employee_net_promote', 1)->where('impact_type', 'pro')->count();
        $anti = DB::table('v_results')->where('employee_net_promote', 1)->where('impact_type', 'anti')->count();
        $sum = $pro + $anti;
        $value = $pro - $anti;
        $result = $sum ? $value / $sum * 100 : 0;
        return $result;
    }

    public function getResultsByDimension($id)
    {
        $results = DB::table('v_dimension_results')->where('poll_instance_id', $id)->get();
        return $results;
    }

    public function getResultsByDimensionAttribute($id)
    {
        $results = DB::table('v_attribute_results')->where('poll_instance_id', $id)->get();
        return $results;
    }

    public function getResultsByDimensionAttributeVariable($id)
    {
        $results = DB::table('v_variable_results')->where('poll_instance_id', $id)->get();
        return $results;
    }

    public function getTopHighAttributes($id)
    {
        $query = DB::table('v_attribute_results')
            ->where('poll_instance_id', $id)
            ->orderBy('value', 'desc')
            ->take(6);
        $results = $query->get();
        return $results;
    }

    public function getTopLowAttributes($id)
    {
        $query = DB::table('v_attribute_results')
            ->where('poll_instance_id', $id)
            ->orderBy('value', 'asc')
            ->take(6);
        $results = $query->get();
        // $results = DB::select($sql, [$id]);
        return $results;
    }

    public function sendReminder(PollInstance $pollInstance)
    {
        $count = 0;
        $pollInstance->participants()
            ->with('person')
            ->whereNull('finish_at')
            ->chunk(50, function ($participants) use (&$count) {
                $count = $count + $participants->count();
                foreach ($participants as $participant) {
                    SendPariticipantReminder::dispatch($participant);
                }
            });


        session()->flash('message', "{$count} recordatorios enviados");
        return Redirect::route('pollInstance.participants', ['pollInstance' => $pollInstance->id]);
    }

    public function getOpenQuestionsWithWords($id)
    {
        $pollInstance = PollInstance::find($id);
        $openQuestions = $pollInstance->poll->openQuestions()->with('openQuestionWords')->get();
        return $openQuestions;
    }

    public function reachByAgeRanges($id)
    {
        $results = Participant::join('age_ranges', 'age_ranges.id', '=', 'age_range_id')
            ->where('poll_instance_id', $id)
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('age_ranges.id')
            ->groupBy('age_ranges.name')
            ->selectRaw('age_ranges.id, age_ranges.name, count(*) as cant')
            ->orderBy('age_ranges.id')
            ->get();

        return response()->json($results);
    }

    public function reachByGenders()
    {
        $results = Participant::join('genders', 'genders.id', '=', 'gender_id')
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('genders.id')
            ->groupBy('genders.name')
            ->selectRaw('genders.id, genders.name, count(*) as cant')
            ->orderBy('genders.id')
            ->get();

        return response()->json($results);
    }

    public function reachByCompanyLevels()
    {
        $results = Participant::join('company_levels', 'company_levels.id', '=', 'company_level_id')
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('company_levels.id')
            ->groupBy('company_levels.name')
            ->selectRaw('company_levels.id, company_levels.name, count(*) as cant')
            ->orderBy('company_levels.id')
            ->get();

        return response()->json($results);
    }

    public function reachByAreas()
    {
        $results = Participant::join('areas', 'areas.id', '=', 'area_id')
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('areas.id')
            ->groupBy('areas.name')
            ->selectRaw('areas.id, areas.name, count(*) as cant')
            ->orderBy('areas.id')
            ->get();

        return response()->json($results);
    }

    public function reachByDivisions()
    {
        $results = Participant::join('divisions', 'divisions.id', '=', 'division_id')
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('divisions.id')
            ->groupBy('divisions.name')
            ->selectRaw('divisions.id, divisions.name, count(*) as cant')
            ->orderBy('divisions.id')
            ->get();

        return response()->json($results);
    }

    public function reachByServiceTime()
    {
        $results = Participant::join('service_time_ranges', 'service_time_ranges.id', '=', 'service_time_range_id')
            ->whereNull('participants.deleted_at')
            ->whereNotNull('finish_at')
            ->groupBy('service_time_ranges.id')
            ->groupBy('service_time_ranges.name')
            ->selectRaw('service_time_ranges.id, service_time_ranges.name, count(*) as cant')
            ->orderBy('service_time_ranges.id')
            ->get();

        return response()->json($results);
    }

    // Dimension replaced by area
    public function deviationByDimension($id)
    {
        $data = DB::table('v_dimension_deviation')
            ->where('poll_instance_id', $id)
            ->get();
        return $data;
    }

    // Attribute replaced by Variable
    public function deviationByAttribute($id)
    {
        $data = DB::table('v_attribute_deviation')
            ->where('poll_instance_id', $id)
            ->get();
        return $data;
    }

    // Variable renombrada por indicador
    public function deviationByVariable($id)
    {
        $data = DB::table('v_variable_deviation')
            ->where('poll_instance_id', $id)
            ->get();
        return $data;
    }

    public function getTopHighIndicators($id)
    {
        $data = DB::table('v_variable_results')
            ->where('poll_instance_id', $id)
            ->orderBy('result', 'desc')
            ->take(10)
            ->get();
        return $data;
    }

    public function getTopLowIndicators($id)
    {
        $data = DB::table('v_variable_results')
            ->where('poll_instance_id', $id)
            ->orderBy('result', 'asc')
            ->take(10)
            ->get();
        return $data;
    }

    public function demographicsDownloads($id, Request $request)
    {

        $groups = DemographicsMap::getGroups();

        return Inertia::render('Company/DemographicsDownloads', ['pollInstanceId' => $id, 'groups' => $groups]);
    }

    public function downloadDemographicGroup($id, Request $request)
    {
        $request->validate(['group' => 'required']);
        $groupName = DemographicsMap::getColumnName($request->group);

        $export = new DemographicsExport($request->group, $id);

        return \Excel::download($export, "Resultados por {$groupName}.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }
}
