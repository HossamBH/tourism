<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Client\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Area;
use App\Models\City;
use App\Http\Controllers\ApiController;

class ClientController extends ApiController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $client = Auth::guard('api')->user();
        if (!$client->area) {
            $client->city;
        } else {
            $client->area->city;
        }

        if ($client) {
            return $this->successResponse($client);
        } else {
            return $this->failedResponse([], 'client not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCustomer(UpdateRequest $request)
    {
        $client = Auth::guard('api')->user();
        if ($client) {
            $client->update($request->except('password'));
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/clients', $image_new_name);
                $client->image = '/uploads/clients/' . $image_new_name;
                $client->save();
            }
            if (!$client->area) {
                $client->city;
            } else {
                $client->area->city;
            }

            return $this->successResponse($client);
        } else {
            return $this->failedResponse($client, 'client not found', 200);
        }
    }
}
