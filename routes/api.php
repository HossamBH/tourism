<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::get('check-token', 'AuthController@checkActivation');
        Route::get('refresh', 'AuthController@refresh');

        // google login
        Route::post('login-google', 'AuthController@loginByGoogle');

        // facebook login
        Route::post('login-facebook', 'AuthController@loginByFacebook');

        // Route::post('reset-password', 'AuthController@resetPassword');
        // Route::post('pin-code', 'AuthController@checkPinCode');
        // Route::post('new-password', 'AuthController@newPassword');
        // Route::post('register-token', 'AuthController@RegisterToken');
        // Route::post('remove-token', 'AuthController@RemoveToken');

        Route::group(['middleware' => 'auth:api'], function ($router) {
            Route::get('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
        });
    });
    Route::group(['middleware' => 'auth:api'], function ($router) {

        //client
        Route::post('customer/update', 'ClientController@updateCustomer');
        Route::get('customer/show', 'ClientController@show');

        //location
        Route::get('areas', 'LocationController@showAreas');
        Route::get('cities', 'LocationController@showCities');
        Route::get('areas/city/{id}', 'LocationController@getAreas');

        //hotels
        Route::get('hotels', 'HotelController@showHotels');
        Route::post('hotel/update/{id}', 'HotelController@updateRating');
        Route::get('hotels/top-rating', 'HotelController@showTopRating');
        Route::post('hotels', 'HotelController@getByLocation');

        //notifications
        Route::get('notifications', 'NotificationController@showNotifications');
        Route::get('notification/{id}', 'NotificationController@count');
        Route::post('token', 'AuthController@registerToken');

        //messages
        Route::post('messages', 'MessageController@store');
        Route::get('messages/dialog/{id}', 'MessageController@getByDialog');

        //show all categories
        Route::get('categories/all', 'CategoriesController@index');
        Route::get('categories/home', 'CategoriesController@home');

        //show all banners
        Route::get('banners', 'BannerController@index');

        //show all places
        Route::post('places/client', 'PlacesController@getByClientLocation');
        Route::get('places/category/{id}', 'PlacesController@getByCategory');
        Route::post('place/update/{id}', 'PlacesController@updateRating');
        Route::get('places/all', 'PlacesController@index');
        Route::post('places', 'PlacesController@getByLocation');

        //top rating places
        Route::get('places/topRating', 'PlacesController@topRating');

        //popular places
        Route::get('places/popular', 'PlacesController@popular');

        //all client dialogs
        Route::get('dialogs', 'DialogController@index');

        //create dialog
        Route::post('dialogs/create', 'DialogController@store');
    });
});
