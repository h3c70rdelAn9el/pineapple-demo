<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChMessage as Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Chatify\Facades\ChatifyMessenger as Chatify;

class AdminBroadcastController extends Controller
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

    /**
     * Show the broadcast message form
     */
    public function index()
    {
        return view('admin.broadcast-message');
    }

    /**
     * Send broadcast message to selected users
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'recipient_type' => 'required|in:all,therapists,admins',
            'test_message' => 'boolean'
        ]);

        // If test message, send only to current admin
        if ($request->test_message) {
            $this->sendTestMessage($request);
            return back()->with('success', 'Test message sent successfully to yourself!');
        }

        // Get recipients based on selection
        $recipients = $this->getRecipients($request->recipient_type);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'No recipients found for the selected criteria.');
        }

        // Send messages to all recipients
        $successCount = 0;
        $failCount = 0;

        foreach ($recipients as $recipient) {
            try {
                // Create message in database
                $message = Chatify::newMessage([
                    'from_id' => Auth::user()->id,
                    'to_id' => $recipient->id,
                    'body' => htmlentities(trim($request->message), ENT_QUOTES, 'UTF-8'),
                    'attachment' => null,
                ]);

                // Parse message for real-time broadcast
                $messageData = Chatify::parseMessage($message);

                // Send real-time notification via Pusher
                Chatify::push("private-chatify.{$recipient->id}", 'messaging', [
                    'from_id' => Auth::user()->id,
                    'to_id' => $recipient->id,
                    'message' => Chatify::messageCard($messageData, true)
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                Log::error("Failed to send broadcast message to user {$recipient->id}: " . $e->getMessage());
            }
        }

        if ($failCount > 0) {
            return back()->with('error', "Message sent to {$successCount} users, but failed to send to {$failCount} users. Please check the logs for details.");
        }

        return back()->with('success', "Broadcast message sent successfully to {$successCount} users!");
    }

    /**
     * Send test message to current admin
     */
    private function sendTestMessage(Request $request)
    {
        $admin = Auth::user();
        
        // Create message in database
        $message = Chatify::newMessage([
            'from_id' => $admin->id,
            'to_id' => $admin->id,
            'body' => htmlentities(trim($request->message . ' (TEST MESSAGE)'), ENT_QUOTES, 'UTF-8'),
            'attachment' => null,
        ]);

        // Parse message for real-time broadcast
        $messageData = Chatify::parseMessage($message);

        // Send real-time notification via Pusher
        Chatify::push("private-chatify.{$admin->id}", 'messaging', [
            'from_id' => $admin->id,
            'to_id' => $admin->id,
            'message' => Chatify::messageCard($messageData, true)
        ]);
    }

    /**
     * Get recipients based on type
     */
    private function getRecipients($type)
    {
        $currentUserId = Auth::user()->id;
        
        switch ($type) {
            case 'therapists':
                return User::where('admin', 0)
                          ->where('id', '!=', $currentUserId)
                          ->get();
            
            case 'admins':
                return User::where('admin', 1)
                          ->where('id', '!=', $currentUserId)
                          ->get();
            
            case 'all':
            default:
                return User::where('id', '!=', $currentUserId)->get();
        }
    }

    /**
     * Get broadcast message history (optional feature)
     */
    public function history()
    {
        // Get messages sent by current admin to multiple users
        // This could be implemented to show broadcast history
        $broadcastMessages = Message::where('from_id', Auth::user()->id)
            ->whereIn('to_id', function($query) {
                $query->select('id')->from('users')->where('id', '!=', Auth::user()->id);
            })
            ->with('toUser')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.broadcast-history', compact('broadcastMessages'));
    }
}
