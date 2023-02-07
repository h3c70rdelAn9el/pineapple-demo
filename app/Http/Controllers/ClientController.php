<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\TherapySession;

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
        // $user = auth()->user();
        // $user = $request->user();

        $c = new Client();
        $c->client_code = $request->client_code;
        $c->legal_name = $request->legal_name;
        $c->preferred_name = $request->preferred_name;
        $c->sexual_orientation = $request->sexual_orientation;
        $c->ethnic_group = $request->ethnic_group;
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
        $c->possible_support_needed = $request->possible_support_needed;
        $c->preferred_language = $request->preferred_language;
        $c->additional_notes = $request->additional_notes;
        $c->pronouns = $request->pronouns;
        $c->email = $request->email;
        $c->phone = $request->phone;
        $c->contact_method = $request->contact_method;
        // $c->user_id = $request->user_id;
        // $c->user_id = $user->id;
        // todo: assign a user id to the client
        $c->user_id = request()->user()->id;
        $c->save();

        // if ($user->admin) {
            // return redirect('/dashboard');
        // } else {

        // }
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
        $client = Client::find($id);
        $therapySessions = TherapySession::all();
        // $therapist = Client::find($user_id);

        $user_id = Client::find($client->user_id);
        // $user_id = $user->id;
// pull in the therapist from user table
$therapist = User::find($user_id);
// dd($therapist);
        return view('clients.show')->with(['client' => $client,  'therapySessions' => $therapySessions, 'therapist' => $therapist]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
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
        //
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
