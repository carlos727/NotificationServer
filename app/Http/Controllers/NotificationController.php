<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Notification;

class NotificationController extends Controller
{
	public function store(Request $request){
		if ($request->has('deviceToken') && $request->has('program') && $request->has('start_at')) {

			$notification = new Notification;
			$notification->deviceToken = $request->input('deviceToken');
			$notification->program = $request->input('program');
			$notification->start_at = $request->input('start_at');
			$notification->save();
			return response($notification, 201);
		}
	}
}