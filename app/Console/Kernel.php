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
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        foreach (scandir($path = app_path('Modules')) as $dir) {
            if (file_exists($filepath = "{$path}/{$dir}/scheduling.php")) {
                require $filepath;
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        foreach (scandir($path = app_path('Modules')) as $dir) {
            if (file_exists($folder_path = "{$path}/{$dir}/Presentation/Commands")) {
                $this->load($folder_path);
            }
        }

        require base_path('routes/console.php');
    }
}
