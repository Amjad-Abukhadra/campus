<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of conversations.
     */
    public function index()
    {
        $conversations = Auth::user()->conversations;
        return view('chat.index', compact('conversations'));
    }

    /**
     * Display the specified conversation.
     */
    public function show(Conversation $conversation)
    {
        // Authorize: Ensure the user is part of the conversation
        if ($conversation->user_one_id !== Auth::id() && $conversation->user_two_id !== Auth::id()) {
            abort(403);
        }

        $conversations = Auth::user()->conversations;
        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        // Mark messages as read
        $conversation->messages()->where('sender_id', '!=', Auth::id())->update(['is_read' => true]);

        return view('chat.show', compact('conversation', 'conversations', 'messages'));
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Broadcast event
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'html' => view('chat.partials.message', ['message' => $message])->render()
            ]);
        }

        return back();
    }

    /**
     * Start a conversation with a user.
     */
    public function start(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot chat with yourself.');
        }

        // Find or create conversation
        $conversation = Conversation::between(Auth::id(), $user->id)->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => Auth::id(),
                'user_two_id' => $user->id,
            ]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Get message partial for AJAX.
     */
    public function getMessagePartial(Message $message)
    {
        // Authorize
        if ($message->conversation->user_one_id !== Auth::id() && $message->conversation->user_two_id !== Auth::id()) {
            abort(403);
        }

        return view('chat.partials.message', compact('message'));
    }
}
