<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use App\Notification;
use Davibennun\LaravelPushNotification\Facades\PushNotification;

class NotificationController extends Controller
{
	public function store(Request $request){
		if ($request->has('deviceToken') && $request->has('program') && $request->has('start_at') && $request->has('day')) {
			$notifications = DB::table('notifications')
								->select('id', 'deviceToken', 'program', 'start_at','day')
								->get();

			$contador = 0;
			foreach ($notifications as $notification) {
				if ($notification->deviceToken == $request->input('deviceToken') &&
					$notification->program == $request->input('program') &&
					$notification->start_at == $request->input('start_at') &&
					$notification->day == $request->input('day')) {
					$contador++;
				}
			}

			if ($contador == 0) {
				$notification = new Notification;
				$notification->deviceToken = $request->input('deviceToken');
				$notification->program = $request->input('program');
				$notification->start_at = $request->input('start_at');
				$notification->day = $request->input('day');
				$notification->save();

				switch ($notification->day) {
					case 0:	$day = "Domingo";break;
					case 1:	$day = "Lunes";break;
					case 2: $day = "Martes";break;
					case 3:	$day = "Miércoles";break;
					case 4:	$day = "Jueves";break;
					case 5:	$day = "Viernes";break;
					case 6:	$day = "Sábado";break;
					default:break;
				}

				PushNotification::app('notificationServerAndroid')
					                ->to($notification->deviceToken)
					                ->send('El programa '.$notification->program.
					                		' sera recordado a las '.$notification->start_at.
					                		' del día '.$day.
					                		'!');

				return response($notification, 201);
			} else {
				PushNotification::app('notificationServerAndroid')
					                ->to($notification->deviceToken)
					                ->send('El programa '.$notification->program.
					                		' ya esta en los contenidos que serán recordados a las '.$notification->start_at.
					                		' del día '.$day.
					                		'!');
			}
		}
	}
}