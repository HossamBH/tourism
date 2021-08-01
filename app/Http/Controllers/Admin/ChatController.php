<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Models\Dialog;
use App\Events\ChatEvent;
use App\Events\ChatClientEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        return view('chat.chat', compact('id'));
    }

    public function fetchAllMessages(Request $request)
    {
        $dialog =  Dialog::where('id', $request->dialog_id)->with('client')->first();
        $chat =  Message::where('dialog_id', $request->dialog_id)->with('user')->get();
        return [$chat, $dialog];
    }

    public function sendMessage(Request $request)
    {
        $dialog = Dialog::findOrFail($request->dialog_id);
        $message = $dialog->messages()->create([
            'body' => $request->body,
            'sender' => 1,
            'check_image' => 0,
            'check_read' => 0,
            'user_id' => Auth::user()->id
        ]);
        broadcast(new ChatEvent($message->load('user')))->toOthers();

        broadcast(new ChatClientEvent($message->load('user'), $dialog->client_id));

        return ['status' => 'success'];
    }
}
