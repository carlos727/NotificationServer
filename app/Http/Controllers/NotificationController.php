<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Notification

class NotificationController extends Controller
{
	public function store(Request $request){
		$this->validate($request, [
		    'deviceToken'	=> 'required',
		    'program'		=> 'required',
		    'start_at'		=> 'required|date_format:Y-m-d H:i:s'
		]);

		$input = $request->all();

    	Notification::create($input);

    	return redirect()->back();
	}

	public function json(){
		$notifications = DB::table('notifications')
					->select('id', 'deviceToken', 'program', 'start_at')
					->get();

		return Response::json($notifications);
	}
}
