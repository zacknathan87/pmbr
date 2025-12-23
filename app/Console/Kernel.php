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
        // $schedule->command('inspire')->hourly();

        $schedule->command('db:backup')->weekly('23:59')->timezone('Asia/Kuala_Lumpur');

        $schedule->call(function () {
            $controller = new \App\Http\Controllers\CronController();
            $controller->checkGame();
        })->cron('* * * * *');

        $schedule->call(function () {
            $controller = new \App\Http\Controllers\CronController();
            $controller->createGame();
        })->dailyAt('00:01');

        $schedule->call(function () {
            $controller = new \App\Http\Controllers\CronController();
            $controller->createGame();
        })->dailyAt('01:00');

        // run robot bet 
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\CronController();
            $controller->robotBet();
        })->cron('* * * * *');

        // delete robot bet
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\CronController();
            $controller->deleteRobotBet();
        })->dailyAt('00:10');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}