<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Company\Participant;
use App\Models\Company\Person;
use App\Models\Operations\PollInstance;
use App\Models\Poll\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with(['city:id,name'])->get();

        return inertia('Company/Index', ['companies' => $companies]);
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
     * @param  \App\Models\Core\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Core\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Core\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Core\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function pollInstancesIndex(Company $company)
    {
        $polls = Poll::all();
        $pollInstances = PollInstance::with('user:id,name', 'poll:id,name')
            ->where('company_id', $company->id)
            ->orderBy('created_at', 'desc')
            ->withCount('participants')
            ->get();

        return Inertia::render('Company/PollsIndex', compact('company', 'polls', 'pollInstances'));
    }

    public function peopleIndex(Company $company)
    {
        $people = $company->people;
        return Inertia::render('Company/PeopleIndex', compact('people', 'company'));
    }

    public function companyPollInstanceParticipantsIndex(Company $company, PollInstance $pollInstance)
    {
        $participants = Participant::where(['company_id' => $company->id, 'poll_instance_id' => $pollInstance->id])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Company/PollInstanceParticipants', compact('participants'));
    }

    /** @var Numeric $id id de la compañía */
    public function pollInstancesStore(Request $request, $id)
    {
        $request->validate([
            'poll_id' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'notes' => 'nullable'
        ]);

        $pollInstance = PollInstance::create(array_merge($request->all(), ['company_id' => $id, 'user_id' => Auth::id(), 'code' => rand(1000, 9999)]));

        return Redirect::route('company.polls', ['company' => $id]);
    }
}
