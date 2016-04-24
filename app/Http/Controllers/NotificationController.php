<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Notification;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Carbon\Carbon;

class NotificationController extends Controller
{
	public function store(Request $request){
		$now = Carbon::now('America/Bogota');
		$day = var_dump($now->dayOfWeek);
		$hour =var_dump($now->hour);
		$minute = var_dump($now->minute);
		$start_at = $hour.":".$minute;

		if ($request->has('deviceToken') && $request->has('program') && $request->has('start_at') && $request->has('day')) {
			$notification = new Notification;
			$notification->deviceToken = $request->input('deviceToken');
			$notification->program = $request->input('program');
			$notification->start_at = $request->input('start_at');
			$notification->day = $request->input('day');
			$notification->save();

			PushNotification::app('notificationServerAndroid')
                ->to($notification->deviceToken)
                ->send(/*'El programa '.$notification->program.
                		' sera recordado a las '.$notification->start_at.
                		' el día '.$notification->day.
                		'!'*/'Prueba Carbon: day='.$day.
                		' HH:mm='.$start_at);

			return response($notification, 201);
		} else {
			$deviceToken = "APA91bF4coca8Mvnj_OxdBFjOHd6OIWOTX0co0dDaQbaEPHlZD0n6eeFZLwNQhOYNbX4w5mTXgvrAm2ZX0NKHYoHMCWRFnymWwf5ts2oPHndNl-rxKGpXabDE2foUute2Znn6gt3bcewlU0KN5LvXd0OJG0K09RcFw";

			PushNotification::app('notificationServerAndroid')
                ->to($deviceToken)
                ->send('El request esta malo! Prueba Carbon: day='.$day.
                		' HH:mm='.$start_at);
		}
	}
}