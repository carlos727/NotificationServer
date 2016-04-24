<?php

// Execte * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use DB;
use Carbon\Carbon;
use Davibennun\LaravelPushNotification\Facades\PushNotification;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\Inspire::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function () {
			$now = Carbon::now('America/Bogota');
			$day = $now->dayOfWeek;

			if ($now->hour < 10) {
				$hour = "0".$now->hour;
			} else {
				$hour = $now->hour;
			}

			if ($now->minute < 10) {
				$minute = "0".$now->minute;
			} else {
				$minute = $now->minute;
			}
			$start_at = $hour.":".$minute;

			$notifications = DB::table('notifications')
								->select('id', 'deviceToken', 'program', 'start_at', 'day')
								->where(['day', $day], ['start_at', $start_at])
								->get();

			foreach ($notifications as $notification) {
				PushNotification::app('notificationServerAndroid')
									->to($notification->deviceToken)
									->send('El programa '.$notification->program.' esta a punto de empezar!');

				$notification->delete();
			}
		})->everyMinute();
	}
}
