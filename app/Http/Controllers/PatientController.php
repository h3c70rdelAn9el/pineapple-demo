<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        // $patients = Patient::where('patient_id',$patient->id)->get();
        // dd($this->$patients);
        // $patients=Patient::all();
        $patient=Patient::all()->where('patient_id', $patient->id)->get();

        // return view('patients', ['patients'=>$patients]);
        return view('dashboard', ['patients'=>$patients]);

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
        // $newPatient = Patient::create([
        //     'first' => $request->first,
        //     'last' => $request->last,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'insurance' => $request->insurance
        // ]);

        $p = new Patient();
        $p->first = $request->first;
        $p->last = $request->last;
        $p->email = $request->email;
        $p->phone = $request->phone;
        $p->insurance = $request->insurance;
        $p->user_id = $user->id;
        $p->save();

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    // public function show(Patient $patient)
    // {
    //             // $patient = Patient::where('slug', $patient->slug)->where('user_id',$user->id)->first();
    //             $patient = Patient::where('first', $patient->first)->where('user_id',$patient->first)->first();

    //             return view('patient', ['patient' => $patient]);

    // }
//     public function show(Patient $patient)
//     {
//         // return $patient;
//                         // $patient = Patient::where('id', $patient->id)->where('id',$patient->id)->first();
// $patient = Patient::where('id', $patient->id)->first();
//         // return view('patient', ['patient' => $patient, 'patient_name' => $patient->first]);
//         return view('patient')->with(['patient' => $patient]);
//     }



 public function show(Request $request, $id)
    {

        // $user = auth()->user();
        // $patient = Patient::where('slug', $patient->slug)->where('patient_id',$patient->id)->first();

        $patient = Patient::find($id);
        return view('patient')->with(['patient' => $patient]);
        // return view('patient');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
