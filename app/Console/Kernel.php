<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		//@mail('artashespapikyan1984@gmail.com','d44444','d444444');
        // $schedule->command('inspire')
        //          ->hourly();
		// $schedule->call(function () { 
		// 	mail('artashespapikyan1984@gmail.com','ddddd555','dddddddddd555');
		// 	app('App\Http\Controllers\MessageController')->send_remind_new_message_emails();
			 
        // })->everyMinute();
        $schedule->command('reminder:cron')
                 ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
