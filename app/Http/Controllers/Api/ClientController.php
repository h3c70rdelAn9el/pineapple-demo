<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ClientSessionsAllocated;
use App\Mail\ClientTherapistAssigned;
use App\Mail\ClientWelcome;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use App\Notifications\ClientMadeInactiveNotification;
use App\Notifications\ClientRemovedNotification;
use App\Notifications\NewClientNotification;
use App\Notifications\SessionsAssignedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $sortBy = $request->get('sort', 'client_code');
        $sortDirection = $request->get('direction', 'asc');

        $allowedSortFields = ['client_code', 'created_at', 'email', 'preferred_name', 'status', 'legal_name'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'client_code';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $clients = Client::where('user_id', $user->id)
            ->orderBy($sortBy, $sortDirection)
            ->with('therapySessions')
            ->paginate(15, ['*'], 'clients');

        $allClients = Client::orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'allClients');
        $therapists = User::where('admin', 0)->get();

        $inactiveClients = Client::where('user_id', $user->id)->where('status', 1)
            ->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'inactiveClients');
        $waitlistClients = Client::where('user_id', $user->id)->where('waitlist', 1)
            ->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'waitlistClients');
        $specialSessionsClients = Client::where('user_id', $user->id)->where('special_sessions', '>', 0)
            ->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'specialSessionsClients');

        $allInactiveClients = Client::where('status', 1)->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'allInactiveClients');
        $allWaitlistClients = Client::where('waitlist', 1)->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'allWaitlistClients');
        $allSpecialSessionClients = Client::where('special_sessions', '>', 0)->orderBy($sortBy, $sortDirection)->paginate(15, ['*'], 'allSpecialSessionClients');

        $therapySessions = TherapySession::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $attendedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))
            ->where('attendance', 'attended')->count();
        $missedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))
            ->where('attendance', 'no-show')->count();

        $categories = Client::$categories;
        $clientsByCategory = [];
        foreach ($categories as $category) {
            $clientsByCategory[$category] = Client::where('category', $category)
                ->orderBy($sortBy, $sortDirection)
                ->paginate(15, ['*'], 'clients_' . str_replace(' ', '_', strtolower($category)));
        }

        return response()->json([
            'clients' => $clients,
            'allClients' => $allClients,
            'therapists' => $therapists,
            'inactiveClients' => $inactiveClients,
            'waitlistClients' => $waitlistClients,
            'specialSessionsClients' => $specialSessionsClients,
            'allInactiveClients' => $allInactiveClients,
            'allWaitlistClients' => $allWaitlistClients,
            'allSpecialSessionClients' => $allSpecialSessionClients,
            'therapySessions' => $therapySessions,
            'attendedSessions' => $attendedSessions,
            'missedSessions' => $missedSessions,
            'clientsByCategory' => $clientsByCategory,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $therapySessions = TherapySession::all();
        $attendedSessions = $client->therapySessions()
            ->whereIn('attendance', ['attended', 'no-show'])
            ->get();
        $therapist = $client->user ?? new User;

        return response()->json([
            'client' => $client,
            'therapySessions' => $therapySessions,
            'therapist' => $therapist,
            'attendedSessions' => $attendedSessions,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        if (!$request->user()->admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $activeTherapists = User::where('active_status', 1)->orderBy('state')->orderBy('name')->get();
        $therapists = User::where('admin', 0)->orderBy('name', 'asc')->get();
        $countries = $this->getCountries();
        $supportTypes = $this->getSupportTypes();
        $states = $this->getStates();
        $maxSessions = Client::max('max_sessions');

        return response()->json([
            'therapists' => $therapists,
            'activeTherapists' => $activeTherapists,
            'countries' => $countries,
            'supportTypes' => $supportTypes,
            'states' => $states,
            'maxSessions' => $maxSessions,
            'ethnicGroups' => $this->getEthnicGroups(),
            'pronouns' => $this->getPronouns(),
            'genders' => $this->getGenders(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_code' => 'required|unique:clients,client_code',
            'cost_per_session' => 'nullable|numeric|min:0',
        ]);

        $client = new Client;

        $client->client_code = $request->client_code;
        $client->legal_name = $request->legal_name;
        $client->preferred_name = $request->preferred_name;
        $client->home_address_line_1 = $request->home_address_line_1;
        $client->home_address_line_2 = $request->home_address_line_2;
        $client->home_address_city = $request->home_address_city;
        $client->home_address_state = $request->home_address_state;
        $client->home_address_zip = $request->home_address_zip;
        $client->home_address_country = $request->home_address_country;
        $client->health_coverage_provider = $request->health_coverage_provider;
        $client->health_coverage_number = $request->health_coverage_number;
        $client->health_coverage_expiration = $request->health_coverage_expiration;
        $client->previous_therapy = $request->previous_therapy ?? 0;
        $client->preferred_language = $request->preferred_language;
        $client->additional_notes = $request->additional_notes;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->user_id = ($request->user_id == 'no_therapist' || empty($request->user_id)) ? 200 : $request->user_id;
        $client->client_contribution = $request->client_contribution;
        $client->cost_per_session = $request->cost_per_session;
        $client->gender = $this->implodeMultiSelect($request->input('gender'), $request->input('otherGender'));
        $client->ethnic_group = $this->implodeMultiSelect($request->input('ethnic_group'), $request->input('otherEthnicGroup'));
        $client->pronouns = $this->implodeMultiSelect($request->input('pronouns'), $request->input('otherPronoun')) ?: ' ';
        $client->contact_method = is_array($request->contact_method) ? implode(', ', $request->contact_method) : '';
        $client->possible_support_needed = $this->implodeMultiSelect($request->input('possible_support_needed'), $request->input('otherPossibleSupport'));
        $client->sexual_orientation = $this->implodeMultiSelect($request->input('sexual_orientation'), $request->input('otherSexualOrientation'));
        $client->special_sessions = $request->input('special_sessions', false);
        $client->max_sessions = $request->input('max_sessions');
        $client->waitlist = $request->input('waitlist', 0);
        $client->category = $request->input('category');
        $client->has_been_contacted = $request->has('has_been_contacted') ? 1 : 0;

        if ($request->input('special_sessions')) {
            $client->special_sessions = 6;
        }

        if ($request->user_id && $request->user_id != 'no_therapist' && !empty($request->user_id)) {
            $therapist = User::find($request->user_id);
            if ($therapist) {
                $therapist->notify(new NewClientNotification);
            }
        }

        $client->save();

        if ($client->special_sessions) {
            for ($i = 0; $i < 6; $i++) {
                $client->therapySessions()->create(['special' => true]);
            }
        }

        $this->notifyAdmins($client, $request->max_sessions, $request->status);
        Mail::to($client->email)->send(new ClientWelcome($client->preferred_name));

        return response()->json(['message' => 'Client added successfully', 'client' => $client], 201);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $request->validate([
            'client_code' => 'nullable',
            'cost_per_session' => 'nullable|numeric|min:0',
        ]);

        $oldTherapist = $client->user_id;
        $oldMaxSessions = $client->max_sessions;

        $client->gender = implode(', ', $request->input('gender', []));
        $client->pronouns = implode(', ', $request->input('pronouns', []));
        $client->ethnic_group = implode(', ', $request->input('ethnic_group', []));
        $client->contact_method = implode(', ', $request->input('contact_method', []));
        $client->sexual_orientation = implode(', ', $request->input('sexual_orientation', []));
        $client->possible_support_needed = implode(', ', $request->input('possible_support_needed', []));

        $client->update([
            'client_code' => $request->input('client_code'),
            'legal_name' => $request->input('legal_name'),
            'preferred_name' => $request->input('preferred_name'),
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
            'cost_per_session' => $request->input('cost_per_session'),
            'user_id' => ($request->input('user_id') == 'no_therapist' || empty($request->input('user_id'))) ? 200 : $request->input('user_id'),
            'gender' => $client->gender,
            'contact_method' => $client->contact_method,
            'max_sessions' => $request->input('max_sessions'),
            'special_sessions' => $request->input('special_sessions', 0),
            'therapist' => $request->input('therapist'),
            'status' => $request->input('status'),
            'waitlist' => $request->input('waitlist', 0),
            'category' => $request->input('category'),
            'has_been_contacted' => $request->has('has_been_contacted') ? 1 : 0,
        ]);

        if ($request->has('status')) {
            $client->status = $request->input('status');
            $client->save();
        }

        // Notify therapists of reassignment
        if ((int) $request->user_id !== (int) $oldTherapist) {
            if ($request->user_id && $request->user_id != 200) {
                $newTherapist = User::find($request->user_id);
                if ($newTherapist) {
                    $newTherapist->notify(new NewClientNotification);
                }
            }
            if ($oldTherapist && $oldTherapist != 200) {
                $previousTherapist = User::find($oldTherapist);
                if ($previousTherapist) {
                    $previousTherapist->notify(new ClientRemovedNotification($client->preferred_name));
                }
            }
            if ($oldTherapist == 200 || $oldTherapist == 0) {
                Mail::to($client->email)->send(new ClientTherapistAssigned($client->preferred_name));
            }
        }

        if ($oldMaxSessions < 2 && $client->max_sessions > 2) {
            Mail::to($client->email)->send(new ClientSessionsAllocated($client->preferred_name, $client->max_sessions));
        }

        $this->notifyAdmins($client, $request->max_sessions, $request->status);

        return response()->json(['message' => 'Client updated successfully', 'client' => $client->fresh()]);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }

    private function implodeMultiSelect(?array $selected, ?string $other = null): string
    {
        if (!is_array($selected)) {
            return $selected ?? '';
        }
        if (in_array('Other', $selected) && $other) {
            return implode(', ', array_map(fn ($v) => $v == 'Other' ? $other : $v, $selected));
        }

        return implode(', ', $selected);
    }

    private function notifyAdmins(Client $client, ?int $sessionCount, ?string $status): void
    {
        $adminUsers = User::where('admin', 1)->get();
        foreach ($adminUsers as $adminUser) {
            $adminUser->notify(new SessionsAssignedNotification($client, $sessionCount));
            if ($status === 'inactive') {
                $therapistName = ($client->user_id && $client->user_id != 200)
                    ? ($client->therapist->preferred_name ?? 'No Therapist')
                    : 'No Therapist';
                $adminUser->notify(new ClientMadeInactiveNotification($client, $therapistName));
            }
        }
    }

    private function getCountries(): array
    {
        return json_decode(File::get(public_path('json/countries.json')), true);
    }

    private function getSupportTypes(): array
    {
        return json_decode(File::get(resource_path('json/categories.json')), true)['categories'];
    }

    private function getStates(): array
    {
        return json_decode(File::get(resource_path('json/states.json')), true)['states'];
    }

    private function getEthnicGroups(): array
    {
        return ['American Indian or Alaska Native', 'Asian', 'Black or African American', 'Hispanic or Latino', 'Native Hawaiian or Other Pacific Islander', 'White', 'prefer not to say'];
    }

    private function getPronouns(): array
    {
        return ['they/them/theirs', 'she/her/hers', 'he/him/his', 'per/per/pers', 'ze/hir/hirs', 'prefer not to say', 'Other'];
    }

    private function getGenders(): array
    {
        return ['Male', 'Female', 'Transgender', 'Genderqueer', 'Genderfluid', 'Agender', 'Bigender', 'Cisgender', 'Non-Binary', 'Prefer Not To Say'];
    }
}
