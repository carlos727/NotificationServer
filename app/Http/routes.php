<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function(){
	return view('welcome');
});

Route::get('/notifications',function(){
	$notifications = DB::table('notifications')
					->select('id', 'deviceToken', 'program', 'start_at', 'day')
					->get();

	return Response::json($notifications);
});

Route::post('/notification', 'NotificationController@store');