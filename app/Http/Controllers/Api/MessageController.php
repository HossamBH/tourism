<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Message\MessageRequest;
use App\Models\Message;
use App\Models\Dialog;
use App\Events\ChatEvent;
use App\Http\Controllers\ApiController;

class MessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create([
            'dialog_id' => $request->dialog_id,
            'body' => $request->body,
            'sender' => 0
        ]);
        if ($message) {
            $message->check_image = 0;
            if ($request->hasFile('body')) {
                $message->check_image = 1;
                $file = $request->body;
                $file_name = time() . $file->getClientOriginalName();
                $file->move('uploads/messages', $file_name);
                $message->body = '/uploads/messages/' . $file_name;
                $message->save();
            }
            if ($message->save()) {

                $dialog = Dialog::where('id', $message->dialog_id)->first();
                $dialog->updated_at = $message->created_at;
                $dialog->save();
            }

            broadcast(new ChatEvent($message->load('user')))->toOthers();

            return $this->successResponse($message);
        } else {
            return $this->failedResponse($message, 'message not found', 200);
        }
    }

    public function getByDialog($id)
    {
        $messages = Message::where('dialog_id', $id)->orderBy('created_at', 'Desc')->paginate(8);

        if ($messages) {
            return $this->successResponse($messages);
        } else {
            return $this->failedResponse($messages, 'messages not found', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
