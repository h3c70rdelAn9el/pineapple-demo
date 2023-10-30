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
    // public function create()
    // {
    //     return view('clients.create');
    // }
    public function create(Request $request)
    {
        if (auth()->user() && auth()->user()->admin === 1) {
            $user_id = $request->user()->id;
            $therapist = User::find($user_id);
            $activeTherapists = User::where('admin', 0)->where('active_status', 0)->orderBy('name', 'asc')->get();
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


            return view('clients.create')->with(['therapists' => $therapists, 'therapist' => $therapist, 'countries' => $countries, 'categories' => $categories, 'states' => $states, 'ethnicGroups' => $ethnicGroups, 'pronouns' => $pronouns, 'genders' => $genders, 'optionKey' => $optionKey, 'activeTherapists' => $activeTherapists, 'inactiveTherapists' => $inactiveTherapists]);
        } else {
            return redirect()->route('dashboard')->with('error', '**You do not have permission to access that page**');
        }
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

        // $genderString = implode(', ', $selectedGenders);
        // $genderString = implode(', ', $request->input('gender'));

        // write an if statement if there is more than one gender selected
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
        // $selectedEthnicGroups = $request->input('ethnic_group');

        // if (is_array($selectedEthnicGroups) && !empty($selectedEthnicGroups)) {
        //     $ethnicGroupArray = $selectedEthnicGroups;
        // } else {
        //     $ethnicGroupArray = [];
        // }

        // $c->ethnic_group = json_encode($ethnicGroupArray);




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
        // $c->possible_support_needed = implode(', ', $request->possible_support_needed);
        // if (is_array($request->possible_support_needed) && !empty($request->possible_support_needed)) {
        //     // $c->possible_support_needed = implode(', ', $request->possible_support_needed);
        //     $c->possible_support_needed = $request->possible_support_needed;
        // } else {
        //     $c->possible_support_needed = '';
        // }
        $c->possible_support_needed = $request->possible_support_needed;
        $c->preferred_language = $request->preferred_language;
        $c->additional_notes = $request->additional_notes;
        $c->pronouns = $request->pronouns;
        $c->email = $request->email;
        $c->phone = $request->phone;
        $c->contact_method = $request->contact_method;
        $c->user_id = $request->user_id;
        $c->client_contribution = $request->client_contribution;
        $c->gender = $genderString;
        $c->ethnic_group = $ethnicGroupString;
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
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        $countries = $this->getCountries();

        $client->client_code = $request->client_code;
        $client->legal_name = $request->legal_name;
        $client->preferred_name = $request->preferred_name;
        $client->sexual_orientation = $request->sexual_orientation;
        $client->ethnic_group = $request->ethnic_group;
        // $client->home_address_line_1 = $request->home_address_line_1;
        // $client->home_address_line_2 = $request->home_address_line_2;
        // $client->home_address_city = $request->home_address_city;
        $client->home_address_state = $request->home_address_state;
        // $client->home_address_zip = $request->home_address_zip;
        $client->home_address_country = $request->home_address_country;
        // $client->health_coverage_provider = $request->health_coverage_provider;
        // $client->health_coverage_number = $request->health_coverage_number;
        // $client->health_coverage_expiration = $request->health_coverage_expiration;
        $client->previous_therapy = $request->previous_therapy;
        $client->possible_support_needed = $request->possible_support_needed;
        // $client->preferred_language = $request->preferred_language;
        $client->additional_notes = $request->additional_notes;
        $client->pronouns = $request->pronouns;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->contact_method = $request->contact_method;
        $client->client_contribution = $request->client_contribution;
        $client->user_id = $request->user_id;
        $client->gender = $request->gender;
        $client->save();

        $therapist = User::find($request->user_id);
        $therapist->notify(new NewClientNotification());
        // return redirect()->route('clients.show', $client->id)->with('success', 'Client updated successfully');
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
        // $therapist = User::find($user_id);
        $therapist = User::where('id', $user_id)->first();

        return view('clients.show')->with(['client' => $client, 'therapySessions' => $therapySessions, 'therapist' => $therapist, 'attendedSessions' => $attendedSessions, 'user' => $user]);
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
        if (auth()->user() && auth()->user()->admin === 1) {
            $client = Client::find($id);
            $countries = $this->getCountries();
            $categories = $this->getCategories();
            $states = $this->getStates();

            return view('clients.edit')->with(['client' => $client, 'countries' => $countries, 'categories' => $categories, 'states' => $states]);
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
