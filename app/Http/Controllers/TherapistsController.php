<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use App\Models\TherapySession;
// use Illuminate\Notifications\Notification;
use App\Notifications\TherapistFileUploaded;
use Illuminate\Support\Facades\Notification;

class TherapistsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $therapists = User::where('admin', 0)->get();
        return view('therapist.index')->with(['therapists' => $therapists]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $therapist = User::find($id);
        // $clients = $therapist->clients()->get();
        $clients = $therapist->clients()->orderBy('preferred_name', 'asc')->get();
        $therapySessions = TherapySession::where("client_id", "=", $therapist->id)->get();
        $file_name = FileUpload::find($id);

        $totalClients = $clients->count();

        $space_for_new_clients = $therapist->number_of_potential_clients - $totalClients;

        return view('therapist.show', [
            'therapist' => $therapist,
            'therapySessions' => $therapySessions,
            'clients' => $clients,
            'user' => $user,
            'file_name' => $file_name,
            'space_for_new_clients' => $space_for_new_clients,
        ]);
    }

    public function edit($id)
    {
        $user = auth()->user();
        if ($user && $user->admin == 1) {


            $therapist = User::find($id);
            $form = $therapist->therapist;
            // dd($therapist);
            return view('therapist.edit', [
                'therapist' => $therapist,
                'user' => $user,
                'form' => $form,
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this therapist');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'gender' => 'nullable|string|max:255',
            'intern' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code_postcode' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'iban_swift_code' => 'nullable|string|max:255',
            'client_spaces' => 'nullable|string|max:255',
            // 'full' => 'nullable|string|max:255',
            // full is  abloolean
            'full' => 'nullable|boolean',
            // 'out_of_state_coaching' => 'nullable|string|max:255'
            'out_of_state_coaching' => 'nullable|boolean',
            // 'contact_for_promotionals' => 'nullable|string|max:255',
            'contact_for_promotionals' => 'nullable|boolean',
            // 'active_status' => 'nullable|string|max:255',
            'active_status' => 'nullable|boolean',
            // 'contract_signed' => 'nullable|string|max:255',
            'contract_signed' => 'nullable|boolean',
            'all_documents' => 'nullable|string|max:255',
            // 'website' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            // 'quickbooks' => 'nullable|string|max:255',
            'quickbooks' => 'nullable|url|max:255',
            // 'session_cost' => 'nullable|string|max:255',
            'session_cost' => 'nullable|numeric',
            // 'client_extensions' => 'nullable|string|max:255',
            // 'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
        ]);

        // Retrieve the existing therapist from the database
        // $therapist = User::find($id);
        $user = User::find($id);

        if ($user->admin == 1) {
            unset($validatedData['full']);
        } else {
            if ($validatedData['space_for_new_clients'] == 0) {
                $validatedData['full'] = 1;
            }
        }


        if (!$user) {
            return redirect()->route('therapist.show', $id)->with('error', 'User not found');
        }

        $user->save();

        // return redirect()->route('therapist.show', $id)->with('success', 'Therapist updated successfully');
        return redirect()->back()->with('success', 'Profile updated!');

    }

}
