<?php

namespace App\Http\Controllers;

use App\Models\ChMessage as Message;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class AdminBroadcastController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Auth::check() || Auth::user()->admin != 1) {
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
            'test_message' => 'boolean',
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

        // Send messages to all recipients with timeout protection
        $successCount = 0;
        $failCount = 0;
        $batchSize = 10; // Process in batches to prevent memory issues
        $maxExecutionTime = 30; // Prevent long-running processes

        // Set a reasonable time limit
        set_time_limit($maxExecutionTime);

        $recipientChunks = $recipients->chunk($batchSize);

        foreach ($recipientChunks as $chunk) {
            foreach ($chunk as $recipient) {
                try {
                    // Check if we're approaching time limit
                    if ((time() - $_SERVER['REQUEST_TIME']) > ($maxExecutionTime - 5)) {
                        Log::warning("Broadcast timeout approaching, stopping at user {$recipient->id}");
                        break 2; // Break out of both loops
                    }

                    // Create message in database
                    $message = Chatify::newMessage([
                        'from_id' => Auth::user()->id,
                        'to_id' => $recipient->id,
                        'body' => e(trim($request->message)),
                        'attachment' => null,
                    ]);

                    // Parse message for real-time broadcast
                    $messageData = Chatify::parseMessage($message);

                    // Send real-time notification via Pusher with timeout protection
                    try {
                        Chatify::push("private-chatify.{$recipient->id}", 'messaging', [
                            'from_id' => Auth::user()->id,
                            'to_id' => $recipient->id,
                            'message' => Chatify::messageCard($messageData, true),
                        ]);
                    } catch (\Exception $pusherException) {
                        Log::warning("Pusher failed for user {$recipient->id}: ".$pusherException->getMessage());
                        // Continue anyway since message is saved in DB
                    }

                    $successCount++;
                } catch (\Exception $e) {
                    $failCount++;
                    Log::error("Failed to send broadcast message to user {$recipient->id}: ".$e->getMessage());
                }
            }

            // Add small delay between batches to prevent overwhelming the system
            usleep(100000); // 0.1 second delay
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
            'body' => htmlentities(trim($request->message.' (TEST MESSAGE)'), ENT_QUOTES, 'UTF-8'),
            'attachment' => null,
        ]);

        // Parse message for real-time broadcast
        $messageData = Chatify::parseMessage($message);

        // Send real-time notification via Pusher
        Chatify::push("private-chatify.{$admin->id}", 'messaging', [
            'from_id' => $admin->id,
            'to_id' => $admin->id,
            'message' => Chatify::messageCard($messageData, true),
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
            ->whereIn('to_id', function ($query) {
                $query->select('id')->from('users')->where('id', '!=', Auth::user()->id);
            })
            ->with('toUser')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.broadcast-history', compact('broadcastMessages'));
    }

    /**
     * Send broadcast message using queue for large recipient lists
     */
    public function sendQueued(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'recipient_type' => 'required|in:all,therapists,admins',
        ]);

        // Get recipients based on selection
        $recipients = $this->getRecipients($request->recipient_type);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'No recipients found for the selected criteria.');
        }

        // For large broadcasts (>50 users), use queue
        if ($recipients->count() > 50) {
            // Dispatch a job for each recipient
            foreach ($recipients as $recipient) {
                Queue::push(function () use ($request, $recipient) {
                    try {
                        $message = Chatify::newMessage([
                            'from_id' => Auth::user()->id,
                            'to_id' => $recipient->id,
                            'body' => e(trim($request->message)),
                            'attachment' => null,
                        ]);

                        $messageData = Chatify::parseMessage($message);

                        Chatify::push("private-chatify.{$recipient->id}", 'messaging', [
                            'from_id' => Auth::user()->id,
                            'to_id' => $recipient->id,
                            'message' => Chatify::messageCard($messageData, true),
                        ]);
                    } catch (\Exception $e) {
                        Log::error("Queued broadcast failed for user {$recipient->id}: ".$e->getMessage());
                    }
                });
            }

            return back()->with('success', "Broadcast message queued for {$recipients->count()} users! Messages will be delivered shortly.");
        }

        // For smaller broadcasts, use the regular method
        return $this->send($request);
    }
}
