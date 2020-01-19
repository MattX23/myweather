<?php

use Illuminate\Http\Request;

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

Route::post('/mailinglist/subscription', 'EmailController@handleSubscription')->name('mail.handleSubscription');
Route::post('/location/get', 'LocationController@fetchLocation')->name('location.get');
Route::post('/location/set', 'PreferredLocationController@setLocation')->name('location.set');
Route::post('/weather/get', 'WeatherController@get')->name('weather.get');



