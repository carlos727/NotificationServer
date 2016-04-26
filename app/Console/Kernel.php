<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Notification;
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
			$day = (int)$now->dayOfWeek;

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

			$notifications = Notification::where('day','=', $day)->orderBy('start_at', 'asc')->get();

			foreach ($notifications as $notification) {
				if ($notification->start_at == $start_at) {
					PushNotification::app('notificationServerAndroid')
										->to($notification->deviceToken)
										->send('El programa '.$notification->program.' esta a punto de empezar!');

					$notification->delete();
				}
			}
		})->everyMinute();
	}
}
