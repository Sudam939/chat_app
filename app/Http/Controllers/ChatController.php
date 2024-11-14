<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat($id)
    {
        $receiver = User::find($id);
        $sender = Auth::user();

        $chats = Chat::where(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $sender->id);
        })->get();

        $users = User::where('id', '!=', Auth::user()->id)->get();

        return view('chat', compact('receiver', 'chats', 'sender', 'users'));
    }


    public function sendMessage(Request $request, $id)
    {
        $receiver = User::find($id);
        $sender = Auth::user();

        $chat = new Chat();
        $chat->sender_id = $sender->id;
        $chat->receiver_id = $receiver->id;
        $chat->message = $request->message;
        $chat->save();

        return redirect()->back();
    }
}
