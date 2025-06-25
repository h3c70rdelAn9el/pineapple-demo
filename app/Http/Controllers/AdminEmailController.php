<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AdminEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->admin != 1) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.email-therapists');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'messagebody' => 'required|string',
            'therapist_type' => 'required|in:all,active,inactive',
            'test_email' => 'boolean'
        ]);

        if ($request->test_email) {
            // Send test email to current admin user
            $this->sendTestEmail($request);
            return back()->with('success', 'Test email sent successfully!');
        }

        // Get therapists based on selection
        $therapists = $this->getTherapists($request->therapist_type);

        if ($therapists->isEmpty()) {
            return back()->with('error', 'No therapists found for the selected criteria.');
        }

        // Send emails to all selected therapists
        foreach ($therapists as $therapist) {
            Mail::send('emails.therapist-notification', [
                'therapist' => $therapist,
                'messagebody' => $request->messagebody,
                'subject' => $request->subject
            ], function ($message) use ($therapist, $request) {
                $message->to($therapist->email)
                        ->subject($request->subject);
            });
        }

        return back()->with('success', "Email sent to {$therapists->count()} therapists successfully!");
    }

    private function sendTestEmail(Request $request)
    {
        $admin = Auth::user();
        
        Mail::send('emails.therapist-notification', [
            'therapist' => $admin,
            'messagebody' => $request->messagebody,
            'subject' => $request->subject . ' (TEST EMAIL)'
        ], function ($message) use ($admin, $request) {
            $message->to($admin->email)
                    ->subject($request->subject . ' (TEST EMAIL)');
        });
    }

    private function getTherapists($type)
    {
        $query = User::where('admin', 0);

        switch ($type) {
            case 'active':
                return $query->where('active_status', 0)->get();
            case 'inactive':
                return $query->where('active_status', 1)->get();
            case 'all':
            default:
                return $query->get();
        }
    }
}
