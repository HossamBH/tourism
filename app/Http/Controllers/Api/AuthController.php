<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Http\Requests\Api\Customer\ResetPasswordRequest;
use App\Http\Requests\Api\Customer\CheckPinCodeRequest;
use App\Http\Requests\Api\Customer\NewPasswordRequest;
use App\Http\Requests\Api\Token\RegisterRequest;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Area;
use App\Models\City;
use App\Models\Token;
use Mail;
use App\Traits\PassportToken;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use PassportToken;

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginByFacebook(Request $request)
    {
        $userID = $request->userID;
        $access_token = $request->access_token;
        //dd($input);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://graph.facebook.com/v9.0/' . $userID . '?fields=id%2Cname%2Cemail&access_token=' . $access_token);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($curl_handle));
        curl_close($curl_handle);
        if (!isset($response->email)) {
            return response()->json(['error' => 'wrong facebook token / this facebook token is already expired.'], 401);
        }

        // we get feedback from google & can use this email for creating a new user
        // then pass it to Laravel passport
        $client = Client::where('email', $response->email)->first();
        if (!$client) {
            $client = new Client();
            $client->email = $response->email;
            $client->save();
        }

        //this traits PassportToken comes in handy
        //you don't need to generate token with password

        if ($token = Auth::guard('api')->login($client)) {
            return $this->respondWithToken($token);
        }

        return response()->json([
            "status" => 0,
            'msg' => 'Unauthorized'
        ], 401);
    }

    /*
    *
    *  login with google using passport package
    *
    */

    public function loginByGoogle(Request $request)
    {

        //dd($request->input('token'));
        $input = $request->input('token');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $input);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($curl_handle));
        curl_close($curl_handle);
        if (!isset($response->email)) {
            return response()->json(['error' => 'wrong google token / this google token is already expired.'], 401);
        }

        // we get feedback from google & can use this email for creating a new user
        // then pass it to Laravel passport
        $client = Client::where('email', $response->email)->first();
        if (!$client) {
            $client = new Client();
            $client->email = $response->email;
            $client->save();
        }

        //this traits PassportToken comes in handy
        //you don't need to generate token with password

        if ($token = Auth::guard('api')->login($client)) {
            return $this->respondWithToken($token);
        }

        return response()->json([
            "status" => 0,
            'msg' => 'Unauthorized'
        ], 401);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        $credentials = request(['phone', 'password']);
        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json([
            "status" => 0,
            'msg' => 'Unauthorized'
        ], 401);
    }

    public function register(CreateRequest $request)
    {

        $client = Client::create($request->all());
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->password = Hash::make($request->password);
        $client->save();

        $credentials = request(['email', 'password']);
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                "status" => 0,
                'msg' => 'Unauthorized'
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $client = Auth::guard('api')->user();
        if (!$client->area) {
            $client->city;
        } else {
            $client->area->city;
        }

        return response()->json([
            'status' => 1,
            'msg' => 'success',
            'data' => $client
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    //public function logout(LogoutRequest $request)
    public function logout()
    {
        //$client = Auth::guard('api')->user();

        // $id = Token::where('device_id', $request->device_id)->where('customer_id', $customer->id)->first();
        // if ($id) {
        //     $id->delete();
        // }

        Auth::guard('api')->logout();
        return response()->json([
            'status' => 1,
            'msg' => 'success'
        ]);
    }
    /* check even the token is valid or not */

    public function checkActivation()
    {
        if (auth('api')->check()) {
            return response()->json([
                'status' => 1,
                'msg' => 'success'
            ]);
        }
        return response()->json([
            'status' => 0,
            'msg' => 'Token Expired'
        ], 401);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    // public function resetPassword(ResetPasswordRequest $request)
    // {
    //     $customer = Customer::where('email', $request->email)->first();
    //     if (!$customer) {
    //         return response()->json([
    //             "status" => 0,
    //             'msg' => 'Wrong Email'
    //         ], 400);
    //     }

    //     $reset = new Reset;
    //     $reset->email = $request->email;
    //     $reset->token = Str::random(60);
    //     $reset->save();
    //     $reset->is_expired = $reset->created_at->addMinutes(30);
    //     $reset->save();

    //     if ($reset) {
    //         $pin_code = rand(111111, 999999);
    //         $reset_pin_code = $reset->update(['pin_code' => $pin_code]);
    //         $reset->save();
    //         $customer_pin_code = $customer->update(['pin_code' => $pin_code]);
    //         if ($customer_pin_code && $reset_pin_code) {
    //             Mail::to($customer->email)
    //                 ->send(new ResetPassword($pin_code));

    //             return response()->json([
    //                 'status' => 1,
    //                 'msg' => 'success',
    //                 'pin_code' => $pin_code
    //             ]);
    //         }
    //     }
    // }
    // public function checkPinCode(CheckPinCodeRequest $request)
    // {
    //     $reset = Reset::where('pin_code', $request->pin_code)->first();
    //     if ($reset) {
    //         $token = $reset->token;
    //         if (Carbon::now() > $reset->is_expired) {
    //             return response()->json([
    //                 "status" => 0,
    //                 'msg' => 'Pin Code has expired'
    //             ], 404);
    //         }
    //         return response()->json([
    //             'status' => 1,
    //             'msg' => 'success',
    //             'data' => $token
    //         ]);
    //     }
    //     return response()->json([
    //         "status" => 0,
    //         'msg' => 'Wrong Pin Code'
    //     ], 400);
    // }
    // public function newPassword(NewPasswordRequest $request)
    // {
    //     $reset = Reset::where('token', $request->token)->first();
    //     if ($reset) {
    //         $customer = Customer::where('pin_code', $reset->pin_code)->first();
    //         $customer->password = Hash::make($request->new_password);
    //         if ($customer->save()) {
    //             $reset->delete();
    //             $customer->pin_code = null;
    //             $customer->save();
    //             return response()->json([
    //                 'status' => 1,
    //                 'msg' => 'success',
    //                 'customer' => $customer
    //             ]);
    //         }
    //     }
    //     return response()->json([
    //         "status" => 0,
    //         'msg' => 'Something went wrong'
    //     ], 400);
    // }

    public function registerToken(RegisterRequest $request)
    {
        $client = Auth::guard('api')->user();

        $getToken = Token::where('client_id', $client->id)->where('device_id', $request->device_id)->first();
        if ($getToken) {
            $getToken->token = $request->token;
            $getToken->save();
            return response()->json([
                'status' => 1,
                'msg' => 'updated',
            ]);
        } else {
            $token = new Token;
            $token->token = $request->token;
            $token->platform = $request->platform;
            $token->device_id = $request->device_id;
            $token->client_id = $client->id;
            $token->save();

            return response()->json([
                'status' => 1,
                'msg' => 'success',
            ]);
        }
    }
}
