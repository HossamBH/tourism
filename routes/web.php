<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/chats/{id}', 'Admin\ChatController@index');
Route::post('/getMessages', 'Admin\ChatController@fetchAllMessages');
Route::post('/messages', 'Admin\ChatController@sendMessage');


Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();
//Route::get('chat', 'Admin\ChatController@chat')->name('chat');
Route::post('send', 'Admin\ChatController@send');

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('/', 'AdminController@index')->name('dashboard');
    //cities
    Route::resource('cities', 'CitiesController');
    //areas
    Route::resource('areas', 'AreasController');
    //users
    Route::resource('users', 'UserController');
    //clients
    Route::resource('clients', 'ClientController');
    //banners
    Route::resource('banners', 'BannersController');
    //categories
    Route::resource('categories', 'CatgeoriesController');
    //places
    Route::resource('places', 'PlacesController');
    //notifications
    Route::resource('notifications', 'NotificationController');
    Route::get('topRatingPlaces', 'PlacesController@topRatedPlaces')->name('places.topRating');
    Route::get('PopularPlaces', 'PlacesController@PopularPlaces')->name('places.PopularPlaces');

    Route::post('activation/{id}', 'PlacesController@activation')->name('places.activation');


    Route::get('places/Popular', 'PlacesController@PopularPlaces');

    //roles
    Route::resource('roles', 'RoleController');
    //get areas by clients_city_id
    Route::get('get_areas/{city}', 'AjaxController@getAreas');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
