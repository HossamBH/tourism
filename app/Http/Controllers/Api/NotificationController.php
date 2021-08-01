<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Hotel\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;

class NotificationController extends ApiController
{
    /**
     * Display a listing of the cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNotifications()
    {
        $client = Auth::guard('api')->user();
        $notifications = Notification::where(function ($query) use ($client) {
            $query->where([
                ['city_id', $client->city_id],
                ['area_id', null]
            ])
                ->orWhere([
                    ['area_id', $client->area_id]
                ])
                ->orWhere([
                    ['city_id', null],
                    ['area_id', null]
                ]);
        })->orderBy('created_at', 'DESC')->paginate(8);

        if ($notifications) {
            return $this->successResponse($notifications);
        } else {
            return $this->failedResponse($notifications, 'notifications not found', 200);
        }
    }

    public function count($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification) {
            $notification->counter++;
            $notification->save();

            return $this->successResponse($notification);
        } else {
            return $this->failedResponse($notification, 'notification not found', 200);
        }
    }
}
