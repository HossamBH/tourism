<?php

namespace App\Http\Controllers\Api;

use App\Models\Dialog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Dialog\CreateRequest;

class DialogController extends ApiController
{
    public function index()
    {
        $client = Auth::guard('api')->user();
        $dialogs = Dialog::where('client_id', $client->id)->paginate(8);
        if ($dialogs->count() == 0) {
            return $this->failedResponse($dialogs, 'Dialogs not found', 200);
        }
        return $this->successResponse($dialogs);
    }

    public function store(CreateRequest $request)
    {
        try {
            $client = Auth::guard('api')->user();
            $dialog = new Dialog;
            $dialog->client_id = $client->id;
            $dialog->type = $request->type;
            $dialog->subject = $request->subject;
            $dialog->save();
            return $this->successResponse($dialog, 'dialog created successfully', 200);
        } catch (\Throwable $th) {
            return $this->failedResponse([], 'Dialog not created', 401);
        }
    }
}
