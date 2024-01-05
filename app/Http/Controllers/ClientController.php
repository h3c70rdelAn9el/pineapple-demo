<?php

namespace App\Http\Controllers;

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

        // do the same as above for contact_method

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
        $client->max_sessions = $request->max_sessions;
        if($request->user_id)
        {

            $therapist = User::find($request->user_id);
            $therapist->notify(new NewClientNotification());
        }

        $client->previous_therapy = $request->previous_therapy ?? 0;

        // $c->ethnic_group = json_encode($ethnicGroupArray);

        // $c->user_id = $user->id;
        // dd($client->gender);
        $client->save();
        return redirect()->route('dashboard');
    }


    // ** THIS IS THE PREVIOUS UPDATE METHOD:
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Client $client)
    // {
    //     // $client = Client::find($id);

    //     $data = $request->only([
    //         'sexual_orientation',
    //         'gender',
    //         'pronouns',
    //         'ethnic_group',
    //         'contact_method',
    //         'possible_support_needed',
    //     ]);

    //     $selectedOrientations = $request->input('sexual_orientation');
    //     $otherSexualOrientation = $request->input('otherSexualOrientation');
    //     $orientationString = "";
    //     if (is_array($selectedOrientations)) {
    //         if (($key = array_search('Other', $selectedOrientations)) !== false && $otherSexualOrientation) {
    //             $selectedOrientations[$key] = $otherSexualOrientation;
    //         }
    //         $client->sexual_orientation = implode(', ', $selectedOrientations);
    //     } else {
    //         $client->sexual_orientation = $client->sexual_orientation;
    //     }

    //     $selectedPronouns = $request->input('pronouns');
    //     $otherPronoun = $request->input('otherPronoun');
    //     $pronounsString = "";
    //     if (is_array($selectedPronouns)) {
    //         if (($key = array_search('Other', $selectedPronouns)) !== false && $otherPronoun) {
    //             $selectedPronouns[$key] = $otherPronoun;
    //         }
    //         $client->pronouns = implode(', ', $selectedPronouns);
    //     } else {
    //         $client->pronouns = $client->pronouns;
    //     }

    //     $selectedGenders = $request->input('gender');
    //     $otherGender = $request->input('otherGender');
    //     $genderString = "";

    //     if (is_array($selectedGenders)) {
    //         if (($key = array_search('Other', $selectedGenders)) !== false && $otherGender) {
    //             $selectedGenders[$key] = $otherGender;
    //         }
    //         $client->gender = implode(', ', $selectedGenders);
    //     } else {
    //         $client->gender = $client->gender;
    //     }

    //     $selectedPossibleSupportNeeded = $request->input('possible_support_needed');
    //     $otherPossibleSupport = $request->input('otherPossibleSupport');
    //     $possibleSupportNeededString = "";

    //     if (is_array($selectedPossibleSupportNeeded)) {
    //         if (($key = array_search('Other', $selectedPossibleSupportNeeded)) !== false && $otherPossibleSupport) {
    //             $selectedPossibleSupportNeeded[$key] = $otherPossibleSupport;
    //         }
    //         $client->possible_support_needed = implode(', ', $selectedPossibleSupportNeeded);
    //     } else {
    //         $client->possible_support_needed = $client->possible_support_needed;
    //     }

    //     // $client->save();

    //     $selectedEthnicGroup = $request->input('ethnic_group');
    //     $otherEthnicGroup = $request->input('otherEthnicGroup');
    //     $ethnicGroupString = "";

    //     if (is_array($selectedEthnicGroup)) {
    //         if (($key = array_search('Other', $selectedEthnicGroup)) !== false && $otherEthnicGroup) {
    //             $selectedEthnicGroup[$key] = $otherEthnicGroup;
    //         }
    //         $client->ethnic_group = implode(', ', $selectedEthnicGroup);
    //     } else {
    //         $client->ethnic_group = $client->ethnic_group;
    //     }

    //     // $client->save();

    //     $selectedContactMethods = $request->input('contact_method');
    //     // $contactMethodString = is_array($selectedContactMethods) && !empty($selectedContactMethods) ? implode(', ', $selectedContactMethods) : $client->contact_method;
    //     if (is_array($selectedContactMethods) && !empty($selectedContactMethods)) {
    //         $contactMethodString = implode(', ', $selectedContactMethods);
    //     } else {
    //         $contactMethodString = $client->contact_method;
    //     }

    //     // $selectedPossibleSupportNeeded = $request->input('possible_support_needed');
    //     // $possibleSupportNeededString = is_array($selectedPossibleSupportNeeded) && !empty($selectedPossibleSupportNeeded) ? implode(', ', $selectedPossibleSupportNeeded) : $client->possible_support_needed;

    //     // $client->client_code = $request->client_code;
    //     // $client->legal_name = $request->legal_name;
    //     // $client->preferred_name = $request->preferred_name;
    //     // // $client->sexual_orientation = $request->sexual_orientation ?? null;
    //     // $client->ethnic_group = $ethnicGroupString;
    //     // $client->home_address_state = $request->home_address_state;
    //     // $client->home_address_country = $request->home_address_country;
    //     // $client->previous_therapy = $request->previous_therapy;
    //     // // $client->possible_support_needed = $request->possible_support_needed;
    //     // $client->additional_notes = $request->additional_notes;
    //     // // $client->pronouns = $request->pronouns ?? null;
    //     // $client->email = $request->email;
    //     // $client->phone = $request->phone;
    //     // $client->client_contribution = $request->client_contribution;
    //     // $client->user_id = $request->user_id;
    //     // $client->gender = $genderString;
    //     // $client->contact_method = $contactMethodString;
    //     // $client->max_sessions = $request->max_sessions;
    //     // $client->possible_support_needed = $possibleSupportNeededString;
    //     // $client->sexual_orientation = $orientationString;
    //     // $client->pronouns = $pronounsString;
    //     $validatedData = $request->validate([
    //         'client_code' =>'nullable',
    //         'legal_name' => 'nullable',
    //         'preferred_name' =>'nullable',
    //         'sexual_orientation' =>'nullable',
    //         'ethnic_group' =>'nullable',
    //         'home_address_state' =>'nullable',
    //         'home_address_country' =>'nullable',
    //         'previous_therapy' =>'nullable',
    //         'possible_support_needed' =>'nullable',
    //         'additional_notes' =>'nullable',
    //         'pronouns' =>'nullable',
    //         'email' =>'nullable',
    //         'phone' =>'nullable',
    //         'client_contribution' =>'nullable',
    //         'user_id' =>'nullable',
    //         'gender' =>'nullable',
    //         'contact_method' =>'nullable',
    //         'max_sessions' =>'nullable',
    //         'sexual_orientation' =>'nullable',
    //         'pronouns' =>'nullable',
    //         'therapist' =>'nullable',
    //     ]);


    //     $therapist = User::find($request->user_id);



    //     if ($request->has('gender')) {
    //         $genderString = implode(', ', $request->input('gender'));
    //         $client->gender = $genderString;
    //     } else {
    //         $client->gender = $client->gender;
    //     }

    //     if ($request->has('pronouns')) {
    //         $pronounsString = json_encode($request->input('pronouns'));
    //         $client->pronouns = str_replace('"', '', trim($pronounsString, '[]'));
    //     } else {
    //         $client->pronouns = $client->pronouns;
    //     }

    //     if ($request->has('ethnic_group')) {
    //         $ethnicGroupString = json_encode($request->input('ethnic_group'));
    //         $client->ethnic_group = str_replace('"', '', trim($ethnicGroupString, '[]'));
    //     } else {
    //         $client->ethnic_group = $client->ethnic_group;
    //     }

    //     if ($request->has('contact_method')) {
    //         $contactMethodString = json_encode($request->input('contact_method'));
    //         $client->contact_method = str_replace('"', '', trim($contactMethodString, '[]'));
    //     } else {
    //         $client->contact_method = $client->contact_method;
    //     }

    //     if ($request->has('possible_support_needed')) {
    //         $possibleSupportNeededString = json_encode($request->input('possible_support_needed'));
    //         $client->possible_support_needed = str_replace('"', '', trim($possibleSupportNeededString, '[]'));
    //     } else {
    //         $client->possible_support_needed = $client->possible_support_needed;
    //     }

    //     // $client->update($data);
    //     $client->update($validatedData);

    //     $therapist = User::find($request->user_id);
    //     $therapist->notify(new NewClientNotification());

    //     return redirect()->route('dashboard');
    // }

    public function update(Request $request, Client $client)
    {
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

        // do the same as above for contact_method

        $selectedContactMethods = $request->input('contact_method') ?? [];
        $contactMethodString = implode(', ', $selectedContactMethods);
        if (is_array($request->contact_method) && !empty($request->contact_method)) {
            $contactMethodString = implode(', ', $request->contact_method);
        } else {
            $contactMethodString = '';
        }

        $selectedGenders = $request->input('gender');


        // Validate the request data
        $validatedData = $request->validate([
            'client_code' => 'nullable',
            // 'legal_name' => 'nullable',
            // a=make legal name a string
            'legal_name' => 'nullable|string',
            'preferred_name' => 'nullable',

            'home_address_state' => 'nullable',
            'home_address_country' => 'nullable',
            'previous_therapy' => 'nullable',

            'additional_notes' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'client_contribution' => 'nullable',
            'user_id' => 'nullable',
            // 'gender' => 'nullable',
            // 'contact_method' => 'nullable',
            // 'sexual_orientation' => 'nullable',
            // 'ethnic_group' => 'nullable',
            // 'possible_support_needed' => 'nullable',
            // 'pronouns' => 'nullable',
            'max_sessions' => 'nullable',
            'user_id' => 'nullable',
            'status' => 'nullable',
        ]);

        $client->client_code = $request->input('client_code');
        // $client->legal_name = $request->input('legal_name');
        // $client->preferred_name = $request->input('preferred_name');

        $client->sexual_orientation = $orientationString;
        $client->pronouns = $pronounsString;
        $client->ethnic_group = $ethnicGroupString;
        $client->contact_method = $contactMethodString;
        $client->possible_support_needed = $possibleSupportNeededString;
        $client->gender = $genderString;


        // Remove quotes and brackets from encoded strings
        // $client->pronouns = str_replace(['"', '[', ']'], '', $client->pronouns);
        // $client->ethnic_group = str_replace(['"', '[', ']'], '', $client->ethnic_group);
        // $client->contact_method = str_replace(['"', '[', ']'], '', $client->contact_method);
        // $client->possible_support_needed = str_replace(['"', '[', ']'], '', $client->possible_support_needed);




        $fieldsToUpdate = ['status', 'legal_name', 'contact_method', 'gender', 'pronouns', 'ethnic_group', 'sexual_orientation', 'possible_support_needed', 'preferred_name', 'contact_method', 'additional_notes', 'client_contribution', 'max_sessions', 'email', 'phone', 'gender', 'additional_notes', 'phone', 'client_contribution', 'user_id', 'home_address_line_1', 'home_address_line_2', 'home_address_city', 'home_address_state', 'home_address_zip', 'home_address_country', 'health_coverage_provider', 'health_coverage_number', 'health_coverage_expiration', 'previous_therapy'];

        foreach ($fieldsToUpdate as $field) {
            if ($request->has($field)) {
                $client->$field = $request->input($field);
            } else {
            }
        }

        // $client->fill($validatedData);
        $client->update($validatedData);
        $client->save();

        // Notify the therapist
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
            // dd($client);


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
        $client->delete();
        return redirect()->route('dashboard');
    }
}
