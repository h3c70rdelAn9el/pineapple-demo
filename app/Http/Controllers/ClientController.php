<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Notifications\NewClientNotification;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $clients = Client::all()->sortBy('client_code');
        foreach ($clients as $client) {
            $client->therapist;
            $client->therapySessions;
        }
        $inactiveClients = $clients->where('status', 1)->sortBy('client_code');
        $waitlistClients = $clients->where('waitlist', 1)->sortBy('client_code');

        $therapist = User::all();

        return view('clients.index', [
            'user' => $user,
            'clients' => $clients,
            'therapist' => $therapist,
            'client' => $client,
            'inactiveClients' => $inactiveClients,
            'waitlistClients' => $waitlistClients,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (auth()->user() && auth()->user()->admin == 1) {
            $user_id = $request->user()->id;
            $therapist = User::find($user_id);
            // $activeTherapists = User::where('admin', 0)->where('active_status', 0)->orderBy('name', 'asc')->get();
            $activeTherapists = User::where('active_status', 1)
                ->orderBy('state')
                ->orderBy('name')
                ->get();


            $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->orderBy('name', 'asc')->get();
            $therapists = User::where('admin', 0)->orderBy('name', 'asc')->get();
            $countries = $this->getCountries();
            $categories = $this->getCategories();
            $states = $this->getStates();
            $ethnicGroups = [
                'American Indian or Alaska Native',
                'Asian',
                'Black or African American',
                'Hispanic or Latino',
                'Native Hawaiian or Other Pacific Islander',
                'White',
                'prefer not to say',
            ];
            $pronouns = [
                'they/them/theirs',
                'she/her/hers',
                'he/him/his',
                'per/per/pers',
                'ze/hir/hirs',
                'prefer not to say',
                'Other'
            ];
            $genders = [
                'Male',
                'Female',
                'Transgender',
                'Genderqueer',
                'Genderfluid',
                'Agender',
                'Bigender',
                'Cisgender',
                'Non-Binary',
                'Prefer Not To Say',
            ];
            $optionKey = 'id';
            // $maxSessions = Client::all()->max('max_sessions');
            $maxSessions = Client::max('max_sessions');


            return view('clients.create')->with(['therapists' => $therapists, 'therapist' => $therapist, 'countries' => $countries, 'categories' => $categories, 'states' => $states, 'ethnicGroups' => $ethnicGroups, 'pronouns' => $pronouns, 'genders' => $genders, 'optionKey' => $optionKey, 'activeTherapists' => $activeTherapists, 'inactiveTherapists' => $inactiveTherapists, 'maxSessions' => $maxSessions]);
        } else {
            return redirect()->route('dashboard')->with('error', '**You do not have permission to access that page**');
        }
    }

    private function getGenders()
    {
        $genders = [
            'Male',
            'Female',
            'Transgender',
            'Genderqueer',
            'Genderfluid',
            'Agender',
            'Bigender',
            'Cisgender',
            'Non-Binary',
            'Prefer Not To Say',
        ];
        return $genders;
    }

    private function getPronouns()
    {
        $pronouns = [
            "He",
            "She",
            "They",
            "Ze",
            "Per",
            "Him",
            "Her",
            "Them",
            "Zir",
            "Prefer Not To Say",
            "Other"
        ];
        return $pronouns;
    }

    private function getSexualOrientations()
    {
        $sexual_orientation = [
            "Heterosexual",
            "Homosexual",
            "Bisexual",
            "Pansexual",
            "Asexual",
            "Demisexual",
            "Queer",
            "Questioning",
            "Prefer Not To Say",
            "Other"
        ];
        return $sexual_orientation;
    }

    private function getCountries()
    {
        // $path = resource_path('/json/countries.json');
        // get it from pulic path
        $path = public_path('json/countries.json');
        $jsonContents = File::get($path);
        $countries = json_decode($jsonContents, true);

        return $countries;
    }

    private function getCategories()
    {
        $path = resource_path('json/categories.json');
        $jsonContents = File::get($path);
        $categories = json_decode($jsonContents, true)['categories'];

        return $categories;
    }

    private function getStates()
    {
        $path = resource_path('json/states.json');
        $jsonContents = File::get($path);
        $states = json_decode($jsonContents, true)['states'];

        return $states;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = auth()->user();
        $user = $request->user();

        $countries = $this->getCountries();
        $categories = $this->getCategories();
        $client = new Client();

        $selectedOrientations = $request->input('sexual_orientation');
        $otherSexualOrientation = $request->input('otherSexualOrientation');
        $orientationString = "";
        if (is_array($selectedOrientations)) {
            if (in_array('Other', $selectedOrientations) && $otherSexualOrientation) {
                $orientationString = implode(', ', array_map(function ($value) use ($otherSexualOrientation) {
                    return $value == 'Other' ? $otherSexualOrientation : $value;
                }, $selectedOrientations));
            } else {
                $orientationString = implode(', ', $selectedOrientations);
            }
        } else {
            $orientationString = $selectedOrientations;
        }

        $selectedPronouns = $request->input('pronouns');
        $otherPronoun = $request->input('otherPronoun');
        $pronounsString = "";
        if (is_array($selectedPronouns)) {
            if (in_array('Other', $selectedPronouns) && $otherPronoun) {
                $pronounsString = implode(', ', array_map(function ($value) use ($otherPronoun) {
                    return $value == 'Other' ? $otherPronoun : $value;
                }, $selectedPronouns));
            } else {
                $pronounsString = implode(', ', $selectedPronouns);
            }
        } else {
            $pronounsString = $selectedPronouns;
        }

        $selectedGenders = $request->input('gender');
        $otherGender = $request->input('otherGender');
        $genderString = "";
        if (is_array($selectedGenders)) {
            if (in_array('Other', $selectedGenders) && $otherGender) {
                $genderString = implode(', ', array_map(function ($value) use ($otherGender) {
                    return $value == 'Other' ? $otherGender : $value;
                }, $selectedGenders));
            } else {
                $genderString = implode(', ', $selectedGenders);
            }
        } else {
            $genderString = $selectedGenders;
        }

        $selectedEthnicGroups = $request->input('ethnic_group');
        $otherEthnicGroup = $request->input('otherEthnicGroup');
        $ethnicGroupString = "";

        if (is_array($selectedEthnicGroups)) {
            if (in_array('Other', $selectedEthnicGroups) && $otherEthnicGroup) {
                $ethnicGroupString = implode(', ', array_map(function ($value) use ($otherEthnicGroup) {
                    return $value == 'Other' ? $otherEthnicGroup : $value;
                }, $selectedEthnicGroups));
            } else {
                $ethnicGroupString = implode(', ', $selectedEthnicGroups);
            }
        } else {
            $ethnicGroupString = $selectedEthnicGroups;
        }

        $selectedPossibleSupportNeeded = $request->input('possible_support_needed');
        $otherPossibleSupport = $request->input('otherPossibleSupport');
        $possibleSupportNeededString = "";

        if (is_array($selectedPossibleSupportNeeded)) {
            if (in_array('Other', $selectedPossibleSupportNeeded) && $otherPossibleSupport) {
                $possibleSupportNeededString = implode(', ', array_map(function ($value) use ($otherPossibleSupport) {
                    return $value == 'Other' ? $otherPossibleSupport : $value;
                }, $selectedPossibleSupportNeeded));
            } else {
                $possibleSupportNeededString = implode(', ', $selectedPossibleSupportNeeded);
            }
        } else {
            $possibleSupportNeededString = $selectedPossibleSupportNeeded;
        }


        $selectedContactMethods = $request->input('contact_method') ?? [];
        $contactMethodString = implode(', ', $selectedContactMethods);
        if (is_array($request->contact_method) && !empty($request->contact_method)) {
            $contactMethodString = implode(', ', $request->contact_method);
        } else {
            $contactMethodString = '';
        }



        // if (is_array($selectedPossibleSupportNeeded) && !empty($selectedPossibleSupportNeeded)) {
        //     $possibleSupportNeededString = implode(', ', $selectedPossibleSupportNeeded);
        // } else {
        //     $possibleSupportNeededString = '';
        // }

        // $c = new Client();
        $request->validate([
            'client_code' => 'required|unique:clients,client_code',
        ]);
        $client->client_code = $request->client_code;
        $client->legal_name = $request->legal_name;
        $client->preferred_name = $request->preferred_name;
        // $c->sexual_orientation = $request->sexual_orientation;
        // $c->ethnic_group = $request->ethnic_group;

        $client->home_address_line_1 = $request->home_address_line_1;
        $client->home_address_line_2 = $request->home_address_line_2;
        $client->home_address_city = $request->home_address_city;
        $client->home_address_state = $request->home_address_state;
        $client->home_address_zip = $request->home_address_zip;
        $client->home_address_country = $request->home_address_country;
        $client->health_coverage_provider = $request->health_coverage_provider;
        $client->health_coverage_number = $request->health_coverage_number;
        $client->health_coverage_expiration = $request->health_coverage_expiration;
        $client->previous_therapy = $request->previous_therapy;

        $client->preferred_language = $request->preferred_language;
        $client->additional_notes = $request->additional_notes;
        // $c->pronouns = $request->pronouns;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->user_id = $request->user_id;
        $client->client_contribution = $request->client_contribution;
        $client->gender = $genderString;
        $client->ethnic_group = $ethnicGroupString;
        $client->pronouns = $pronounsString ?? ' ';
        $client->contact_method = $contactMethodString;
        $client->possible_support_needed = $possibleSupportNeededString;
        $client->sexual_orientation = $orientationString;
        // $client->max_sessions = $request->max_sessions;
        $client->special_sessions = $request->input('special_sessions', false);
        $client->max_sessions = $request->input('max_sessions', 16);

        $client->waitlist = $request->input('waitlist', 0);
        $client->special_sessions = $request->input('special_sessions', 6);

        if ($request->user_id) {

            $therapist = User::find($request->user_id);
            $therapist->notify(new NewClientNotification());
        }

        $client->previous_therapy = $request->previous_therapy ?? 0;

        if ($request->input('special_sessions')) {
            $client->special_sessions = 6;
            $client->max_sessions = 16;
        } else {
            $client->max_sessions = 16;
        }

        // $c->ethnic_group = json_encode($ethnicGroupArray);

        // $c->user_id = $user->id;
        // dd($client->gender);
        $client->save();


        if ($client->special_sessions) {
            for ($i = 0; $i < 6; $i++) {
                $client->therapySessions()->create([
                    // other session fields...
                    'special' => true,
                ]);
            }
        }

        return redirect()->route('dashboard');
    }


    // ** THIS IS THE PREVIOUS UPDATE METHOD:
    // ** THIS IS THE PREVIOUS UPDATE METHOD:
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'client_code' => 'nullable',
            'legal_name' => 'nullable',
            'preferred_name' => 'nullable',
            'sexual_orientation' => 'nullable',
            'ethnic_group' => 'nullable',
            'home_address_state' => 'nullable',
            'home_address_country' => 'nullable',
            'previous_therapy' => 'nullable',
            'possible_support_needed' => 'nullable',
            'additional_notes' => 'nullable',
            'pronouns' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'client_contribution' => 'nullable',
            'user_id' => 'nullable',
            'gender' => 'nullable',
            'contact_method' => 'nullable',
            'max_sessions' => 'nullable',
            'therapist' => 'nullable',
            'status' => 'nullable',
            'waitlist' => 'nullable',
        ]);

        $client->gender = implode(', ', $request->input('gender', []));
        $client->pronouns = implode(', ', $request->input('pronouns', []));
        $client->ethnic_group = implode(', ', $request->input('ethnic_group', []));
        $client->contact_method = implode(', ', $request->input('contact_method', []));
        // $client->possible_support_needed = json_encode($request->input('possible_support_needed', []));
        $client->sexual_orientation = implode(', ', $request->input('sexual_orientation', []));
        $client->possible_support_needed = implode(', ', $request->input('possible_support_needed', []));



        // Update the client fields

        $client->update([
            'client_code' => $request->input('client_code'),
            'legal_name' => $request->input('legal_name'),
            // 'legal_name' => $client->legal_name,
            'preferred_name' => $request->input('preferred_name'),
            // 'sexual_orientation' => $request->input('sexual_orientation'),
            'sexual_orientation' => $client->sexual_orientation,
            'ethnic_group' => $client->ethnic_group,
            'home_address_state' => $request->input('home_address_state'),
            'home_address_country' => $request->input('home_address_country'),
            'previous_therapy' => $request->input('previous_therapy'),
            'possible_support_needed' => $client->possible_support_needed,
            'additional_notes' => $request->input('additional_notes'),
            'pronouns' => $client->pronouns,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'client_contribution' => $request->input('client_contribution'),
            'user_id' => $request->input('user_id'),
            'gender' => $client->gender,
            'contact_method' => $client->contact_method,
            // 'max_sessions' => $request->input('max_sessions'),
            'max_sessions' => $request->input('special_sessions') ? 10 : 16,
            'special_sessions' => $request->has('special_sessions') ? 6 : 0,
            'therapist' => $request->input('therapist'),
            'status' => $request->input('status'),
            'waitlist' => $request->input('waitlist', 0),
            'special_sessions' => $request->input('special_sessions', 0),
        ]);

        // $client->update($validatedData);
        // Update the client fields (excluding 'status')
        // unset($validatedData['status']);

        if ($request->input('special_sessions')) {
            $client->special_sessions = 6;
            $client->max_sessions = 10;
        } else {
            $client->max_sessions = 16;
        }

        // Update 'status' separately
        if ($request->has('status')) {
            $client->status = $request->input('status');
            $client->save();
        }

        // Notify the therapist
        if ($request->user_id) {
            $therapist = User::find($request->user_id);
            $therapist->notify(new NewClientNotification());
        }


        return redirect()->route('dashboard');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $client = Client::find($id, ['*'], 'preferred_name', 'asc');
        $therapySessions = TherapySession::all();
        $attendedSessions = $client->therapySessions()
            ->whereIn('attendance', ['attended', 'no-show'])
            ->get();
        $user_id = $client->user_id;
        $user = $request->user();
        $id = $client->id;
        // $therapist = User::find($user_id);
        $therapist = User::where('id', $user_id)->first();

        return view('clients.show')->with(['client' => $client, 'therapySessions' => $therapySessions, 'therapist' => $therapist, 'attendedSessions' => $attendedSessions, 'user' => $user, 'id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    // public function edit(Client $client)
    // {

    // }
    public function edit(Request $request, $id)
    {

        // if (config('app.maintenance')) {
        //     return redirect('/maintenance');
        // }

        if (auth()->user() && auth()->user()->admin == 1) {
            $client = Client::find($id);
            $countries = $this->getCountries();
            $categories = $this->getCategories();
            $states = $this->getStates();
            $id = $client->id;
            $therapist = User::find($client->user_id);
            $therapists = User::where('admin', 0)->orderBy('name', 'asc')->get();
            $user_id = $client->user_id;
            $genders = $this->getGenders();
            $sexualOrientations = $this->getSexualOrientations();
            $pronouns = $this->getPronouns();
            $selectedPossibleSupport = $this->getCategories();
            // dd($client);


            return view('clients.edit')->with(['client' => $client, 'countries' => $countries, 'categories' => $categories, 'states' => $states, 'id' => $id, 'therapist' => $therapist, 'therapists' => $therapists, 'user_id' => $user_id, 'genders' => $genders, 'sexualOrientations' => $sexualOrientations, 'pronouns' => $pronouns, 'selectedPossibleSupport' => $selectedPossibleSupport]);
        } else {
            return redirect()->route('dashboard')->with('error', '**You do not have permission to access that page**');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('dashboard');
    }
}
