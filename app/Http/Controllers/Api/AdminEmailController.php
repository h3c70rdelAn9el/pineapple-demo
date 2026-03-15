<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminEmailController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        if (!$request->user()?->admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'messagebody' => 'required|string',
            'therapist_type' => 'required|in:all,active,inactive',
            'test_email' => 'boolean',
        ]);

        if ($request->test_email) {
            $admin = Auth::user();
            Mail::send('emails.therapist-notification', [
                'therapist' => $admin,
                'messagebody' => $request->messagebody,
                'subject' => $request->subject . ' (TEST EMAIL)',
            ], function ($message) use ($admin, $request) {
                $message->to($admin->email)->subject($request->subject . ' (TEST EMAIL)');
            });

            return response()->json(['message' => 'Test email sent successfully!']);
        }

        $query = User::where('admin', 0);
        $therapists = match ($request->therapist_type) {
            'active' => $query->where('active_status', 0)->get(),
            'inactive' => $query->where('active_status', 1)->get(),
            default => $query->get(),
        };

        if ($therapists->isEmpty()) {
            return response()->json(['message' => 'No therapists found.'], 422);
        }

        foreach ($therapists as $therapist) {
            Mail::send('emails.therapist-notification', [
                'therapist' => $therapist,
                'messagebody' => $request->messagebody,
                'subject' => $request->subject,
            ], function ($message) use ($therapist, $request) {
                $message->to($therapist->email)->subject($request->subject);
            });
        }

        return response()->json(['message' => "Email sent to {$therapists->count()} therapists successfully!"]);
    }
}
