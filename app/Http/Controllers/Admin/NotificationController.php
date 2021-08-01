<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\NotificationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Notification\CreateRequest;
use App\Models\City;
use App\Models\Area;
use App\Models\Notification;
use App\Models\Client;
use App\Models\Token;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $notifications = Notification::all();
        return view('Admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $areas = Area::all();
        return view('Admin.notifications.create', compact('cities', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $notification = Notification::create($request->all());
        $notification->save();
        if ($notification->is_pushed == 1) {
            if ($notification->area_id == null) {
                if ($notification->city_id == null) {
                    $clientId = Client::all('id');
                } else {
                    $clientId = Client::where('city_id', $notification->city_id)->select('id')->get();
                }
            } else {
                $clientId = Client::where('area_id', $notification->area_id)->select('id')->get();
            }
            if (count($clientId)) {
                $tokens = Token::whereIn('client_id', $clientId)->where('token', '!=', null)->pluck('token')->toArray();

                if ($tokens) {
                    $title = $notification->subject;
                    $body = $notification->body;

                    $send = $this->notifyByFirebase($title, $body, $tokens);
                    //dd($send);
                }
            }
        }
        return redirect(route('admin.notifications.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $cities = City::all();
        $areas = Area::all();
        return view('Admin.notifications.show', compact('notification', 'cities', 'areas'));
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
    public function update(Request $request)
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
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return back();
    }

    function notifyByFirebase($title, $content, $tokens)
    {
        $registrationIDs = $tokens;
        $fcmMsg = array(
            'body' => $content,
            'title' => $title,
            'sound' => "default",
            'color' => "#203E78"
        );

        $fcmFields = array(
            'registration_ids' => $registrationIDs,
            'priority' => 'high',
            'notification' => $fcmMsg
        );

        $headers = array(
            'Authorization: key= AAAAv6CiIZg:APA91bGuJ5K70nPGjIYeaPd8nQ3NBGGrbaLXKgb3bZQSLtsXty95vo2WisfYPBSuR57YdBHkms42BBlMEcorqjMecwaX1G_sC5DCwCEmcIWsFFmy4mv2b28xKqu7JtBAZzh2y3aGXM9L',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
