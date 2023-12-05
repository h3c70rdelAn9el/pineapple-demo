<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\TherapySession;
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
        $client = Client::all()
            ->where('client_id', $client->id)
            ->get();

        // return view('dashboard', ['client'=>$clients]);
        // return view('therapist.show', ['client' => $clients()]);
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
                'Other'
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

        $selectedGenders = $request->input('gender');
        if (is_array($selectedGenders) && !empty($selectedGenders)) {
            $genderString = implode(', ', $selectedGenders);
        } else {
            $genderString = '';
        }

        $selectedEthnicGroups = $request->input('ethnic_group');
        if (is_array($selectedEthnicGroups) && !empty($selectedEthnicGroups)) {
            $ethnicGroupString = implode(', ', $selectedEthnicGroups);
        } else {
            $ethnicGroupString = '';
        }

        // do the same as above for contact_method
        $selectedContactMethods = $request->input('contact_method');
        $contactMethodString = implode(', ', $selectedContactMethods);
        if (is_array($request->contact_method) && !empty($request->contact_method)) {
            $contactMethodString = implode(', ', $request->contact_method);
        } else {
            $contactMethodString = '';
        }

        $selectedPossibleSupportNeeded = $request->input('possible_support_needed');
        if (is_array($selectedPossibleSupportNeeded) && !empty($selectedPossibleSupportNeeded)) {
            $possibleSupportNeededString = implode(', ', $selectedPossibleSupportNeeded);
        } else {
            $possibleSupportNeededString = '';
        }

        $c = new Client();
        $c->client_code = $request->client_code;
        $c->legal_name = $request->legal_name;
        $c->preferred_name = $request->preferred_name;
        $c->sexual_orientation = $request->sexual_orientation;
        // $c->ethnic_group = $request->ethnic_group;

        $c->home_address_line_1 = $request->home_address_line_1;
        $c->home_address_line_2 = $request->home_address_line_2;
        $c->home_address_city = $request->home_address_city;
        $c->home_address_state = $request->home_address_state;
        $c->home_address_zip = $request->home_address_zip;
        $c->home_address_country = $request->home_address_country;
        $c->health_coverage_provider = $request->health_coverage_provider;
        $c->health_coverage_number = $request->health_coverage_number;
        $c->health_coverage_expiration = $request->health_coverage_expiration;
        $c->previous_therapy = $request->previous_therapy;
        $c->contact_method = $contactMethodString;
        $c->possible_support_needed = $possibleSupportNeededString;
        $c->preferred_language = $request->preferred_language;
        $c->additional_notes = $request->additional_notes;
        $c->pronouns = $request->pronouns;
        $c->email = $request->email;
        $c->phone = $request->phone;
        $c->user_id = $request->user_id;
        $c->client_contribution = $request->client_contribution;
        $c->gender = $genderString;
        $c->ethnic_group = $ethnicGroupString;
        $c->max_sessions = $request->max_sessions;
        $therapist = User::find($request->user_id);
        $therapist->notify(new NewClientNotification());
        // $c->ethnic_group = json_encode($ethnicGroupArray);

        // $c->user_id = $user->id;

        $c->save();
        return redirect()->route('dashboard');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // $client = Client::find($id);

        $data = $request->only([
            'sexual_orientation',
            'gender',
            'pronouns',
            'ethnic_group',
            'contact_method',
            'possible_support_needed',
        ]);

        $selectedOrientations = $request->input('sexual_orientation');
        if (is_array($selectedOrientations) && !empty($selectedOrientations)) {
            $orientationString = implode(', ', $selectedOrientations);
        } else {
            $orientationString = $client->sexual_orientation;
        }

        $selectedPronouns = $request->input('pronouns');
        if (is_array($selectedPronouns) && !empty($selectedPronouns)) {
            $pronounsString = implode(', ', $selectedPronouns);
        } else {
            $pronounsString = $client->pronouns;
        }


        // $selectedGenders = $request->input('gender');
        // $genderString = is_array($selectedGenders) && !empty($selectedGenders) ? implode(', ', $selectedGenders) : $client->sexual_orientation;
        $selectedGenders = $request->input('gender');
        if (is_array($selectedGenders) && !empty($selectedGenders)) {
            $genderString = implode(', ', $selectedGenders);
        } else {
            $genderString = $client->gender;
        }

        $selectedEthnicGroups = $request->input('ethnic_group');
        if (is_array($selectedEthnicGroups) && !empty($selectedEthnicGroups)) {
            $ethnicGroupString = implode(', ', $selectedEthnicGroups);
        } else {
            $ethnicGroupString = $client->ethnic_group;
        }

        $selectedContactMethods = $request->input('contact_method');
        $contactMethodString = is_array($selectedContactMethods) && !empty($selectedContactMethods) ? implode(', ', $selectedContactMethods) : $client->contact_method;

        $selectedPossibleSupportNeeded = $request->input('possible_support_needed');
        $possibleSupportNeededString = is_array($selectedPossibleSupportNeeded) && !empty($selectedPossibleSupportNeeded) ? implode(', ', $selectedPossibleSupportNeeded) : $client->possible_support_needed;

        $client->client_code = $request->client_code;
        $client->legal_name = $request->legal_name;
        $client->preferred_name = $request->preferred_name;
        // $client->sexual_orientation = $request->sexual_orientation ?? null;
        $client->ethnic_group = $ethnicGroupString;
        $client->home_address_state = $request->home_address_state;
        $client->home_address_country = $request->home_address_country;
        $client->previous_therapy = $request->previous_therapy;
        // $client->possible_support_needed = $request->possible_support_needed;
        $client->additional_notes = $request->additional_notes;
        // $client->pronouns = $request->pronouns ?? null;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->client_contribution = $request->client_contribution;
        $client->user_id = $request->user_id;
        $client->gender = $genderString;
        $client->contact_method = $contactMethodString;
        $client->max_sessions = $request->max_sessions;
        $client->possible_support_needed = $possibleSupportNeededString;
        $client->sexual_orientation = $orientationString;
        $client->pronouns = $pronounsString;


        if ($request->has('gender')) {
            $genderString = implode(', ', $request->input('gender'));
            $client->gender = $genderString;
        } else {
            $client->gender = $client->gender;
        }

        if ($request->has('pronouns')) {
            $pronounsString = json_encode($request->input('pronouns'));
            $client->pronouns = str_replace('"', '', trim($pronounsString, '[]'));
        } else {
            $client->pronouns = $client->pronouns;
        }

        if ($request->has('ethnic_group')) {
            $ethnicGroupString = json_encode($request->input('ethnic_group'));
            $client->ethnic_group = str_replace('"', '', trim($ethnicGroupString, '[]'));
        } else {
            $client->ethnic_group = $client->ethnic_group;
        }

        if ($request->has('contact_method')) {
            $contactMethodString = json_encode($request->input('contact_method'));
            $client->contact_method = str_replace('"', '', trim($contactMethodString, '[]'));
        } else {
            $client->contact_method = $client->contact_method;
        }

        if ($request->has('possible_support_needed')) {
            $possibleSupportNeededString = json_encode($request->input('possible_support_needed'));
            $client->possible_support_needed = str_replace('"', '', trim($possibleSupportNeededString, '[]'));
        } else {
            $client->possible_support_needed = $client->possible_support_needed;
        }

        $client->update($data);

        $therapist = User::find($request->user_id);
        $therapist->notify(new NewClientNotification());

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


            return view('clients.edit')->with(['client' => $client, 'countries' => $countries, 'categories' => $categories, 'states' => $states, 'id' => $id, 'therapist' => $therapist, 'therapists' => $therapists, 'user_id' => $user_id, 'genders' => $genders, 'sexualOrientations' => $sexualOrientations, 'pronouns' => $pronouns]);
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
        //
    }
}
