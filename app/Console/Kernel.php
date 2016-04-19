<?php

// Execte * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

require 'vendor/autoload.php';

use Carbon\Carbon;
use App\Notification;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//\App\Console\Commands\Inspire::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		/*
		$schedule->call(function () {
			$now = Carbon::now()->toDateTimeString();
            $notifications = DB::table('notifications')
					->select('id', 'deviceToken', 'program', 'start_at')
					->where('start_at', '=', $now)
					->get();

			foreach ($notifications as $notification) {
				PushNotification::app('UninorteFM')
                ->to($notification->deviceToken)
                ->send('El programa '.$notification->program.' esta a punto de empezar!');
                $notification->delete();
			}
        })->everyMinute();
        */
	}
}
