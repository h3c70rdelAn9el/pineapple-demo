<?php

namespace App\Http\Controllers;

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
        $user = $request->user();

        $c = new Client();
        $c->client_code = $request->client_code;
        $c->chosen_name = $request->chosen_name;
        $c->pronouns = $request->pronouns;
        $c->email = $request->email;
        $c->phone = $request->phone;
        $c->contact_method = $request->contact_method;
        // $c->user_id = $request->user_id;
        $c->user_id = $user->id;
        $c->save();

        if ($user->admin) {
            return redirect('/dashboard');
        } else {
            return 404;
        }
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
        return view('clients.show')->with(['client' => $client,  'therapySessions' => $therapySessions]);
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
