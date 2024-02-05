<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use App\Models\TherapySession;
// use Illuminate\\Notification;
use Illuminate\Validation\Rule;
use App\Notifications\TherapistFileUploaded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TherapistsController extends Controller
{


    public function index()
    {
        $user = auth()->user();
        $therapists = User::where('admin', 0)->paginate(15);
        $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->paginate(15);

        // Filter therapists with incomplete data
        $incompleteTherapists = $therapists->filter(function ($therapist) {
            $fieldsToCheck = [
                'contract_signed' => $therapist->contract_signed,
                'public_liability_insurance' => $therapist->public_liability_insurance,
                'all_documents' => $therapist->all_documents,
                'signed_documents' => $therapist->signed_documents,
                'leah_signed' => $therapist->leah_signed,
            ];

            foreach ($fieldsToCheck as $field) {
                if (is_null($field) || $field === false) {
                    return true;
                }
            }

            return false;
        });

        $inactiveTherapist = User::where('admin', 0)->where('active_status', 1);
        $inactiveTherapistsCount = $inactiveTherapists->total();

        // Check if the authenticated user (therapist) has incomplete data
        $therapist = User::find($user->id);
        $incompleteTherapist = false;

        if ($therapist) {
            $fieldsToCheck = [
                'contract_signed' => $therapist->contract_signed,
                'public_liability_insurance' => $therapist->public_liability_insurance,
                'all_documents_received' => $therapist->all_documents_received,
            ];

            foreach ($fieldsToCheck as $field) {
                if (is_null($field) || $field === false) {
                    $incompleteTherapist = true;
                    break;
                }
            }
        }

        return view('therapist.index')->with([
            'therapists' => $therapists,
            'therapist' => $user,
            'inactiveTherapists' => $inactiveTherapists,
            'inactiveTherapistsCount' => $inactiveTherapistsCount,
            'incompleteTherapists' => $incompleteTherapists,
            'incompleteTherapist' => $incompleteTherapist,
            'inactiveTherapist' => $inactiveTherapist,
        ]);
    }



    public function show($id)
    {
        $user = auth()->user();
        $therapist = User::find($id);
        $clients = $therapist->clients()->get();
        //$clients = $therapist->clients()->orderBy('preferred_name', 'asc')->get();
        $therapySessions = TherapySession::where("client_id", "=", $therapist->id)->get();
        $file_name = FileUpload::find($id);

        $totalSessionCost = number_format($therapist->sum('session_cost'), 2, '.', '');
        $totalClientContribution = number_format($clients->sum('client_contribution'), 2, '.', '');
        $total = number_format($totalSessionCost - $totalClientContribution, 2, '.', '');

        $totalClients = $clients->count();

        $space_for_new_clients = (int)$therapist->number_of_potential_clients - $totalClients;

        return view('therapist.show', [
            'therapist' => $therapist,
            'therapySessions' => $therapySessions,
            'clients' => $clients,
            'user' => $user,
            'file_name' => $file_name,
            'space_for_new_clients' => $space_for_new_clients,
            'total' => $total,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
        ]);
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
                'id' => $id,
                'genders' => $this->getGenders(),
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this therapist');
        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $selectedGenders = $request->input('gender');
        $otherGender = $request->input('otherGender');
        // $genderString = "";
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

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            // 'gender' => 'nullable|string|max:255',
            'intern' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'county_town' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code_postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'iban_swift_code' => 'nullable|string|max:255',
            'client_spaces' => 'nullable|string|max:255',
            'full' => 'nullable|boolean',
            'out_of_state_coaching' => 'nullable|boolean',
            'contact_for_promotionals' => 'nullable|boolean',
            'active_status' => 'nullable|boolean',
            'contract_signed' => 'nullable|boolean',
            'all_documents' => 'nullable|string|max:255',
            'website' => 'nullable|boolean',
            'quickbooks' => 'nullable|string|max:255',
            'session_cost' => 'nullable|numeric',
            // 'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
            'number_of_potential_clients' => 'nullable|numeric',
            'currencyCode' => 'nullable|string|max:255',

            // 'gender' => $genderString


        ]);

        // Log('User currency: ' . $user->currency);
        $user = User::find($id);

        $validatedData['gender'] = $genderString;

        $user->currency = $request->currencyCode;

        dd($validatedData, $user->currency);
        if (!$user) {
            return redirect()->route('therapist.show', $id)->with('error', 'User not found');
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Profile updated!');
    }
}
