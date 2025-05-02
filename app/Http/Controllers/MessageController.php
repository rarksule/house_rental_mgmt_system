<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'message';
        $users = User::whereHas('sentMessages', function ($query) {
            $query->where('receiver_id', auth()->user()->id);
        })
            ->orWhereHas('receivedMessages', function ($query) {
                $query->where('sender_id', auth()->user()->id);
            })
            ->get();
        $receiver = $request->has('receiver_id') ? User::find($request->receiver_id) : $users->first();

        $receiverId = $request->receiver_id ?? optional($receiver)->id ?? null;
        if($receiverId){
            $myMessages = Message::where('receiver_id', auth()->user()->id)->where('sender_id',$receiverId)->get();
        }else{
            $myMessages = Message::where('receiver_id', auth()->user()->id)->get();  
        }
        
        foreach ($myMessages as $message) {
            if (!$message->isread) {
                $message->isread = true;
                $message->save();
            }
        }
        $messages = Message::with('sender')
            ->where(function ($query) use ($receiverId) {
                $query->where('sender_id', auth()->user()->id)
                    ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', auth()->user()->id);
            })
            ->latest()
            ->take(20)
            ->get()
            ->reverse();
        return view('owner.message', compact(['messages', 'pageTitle', 'users', 'receiver']));
    }

    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:1000',
            'id' => 'required|integer'
        ]);
        if ($request->id == auth()->id()) {

            if ($request->wantsJson) {
                return response()->json([
                    'success' => true,
                    'message' => 'you can\'t message yourself',
                ]);
            }
            return back()->with('error', 'you can\'t message yourself');
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->id,
            'content' => $request->content,
        ]);

        if ($request->wantsJson) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Message sent!');
    }
}

