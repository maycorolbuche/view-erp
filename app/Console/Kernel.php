<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('task:close_authorizations')->daily()->between('00:00', '04:00');
        $schedule->command('task:close_batches_without_refund')->daily()->between('00:00', '04:00');

        $schedule->command('task:migrate')->daily()->between('00:00', '04:00');
        $schedule->command('task:remove_old_logs')->daily()->between('00:00', '04:00');

        $schedule->command('task:delete_excess_files')->daily()->between('00:00', '04:00');

        $schedule->command('task:backup')->daily()->between('00:00', '04:00');

        //$schedule->command('task:close_authorizations')->everyMinute();
        //->everyMinute()

        //No servidor - CRONTAB:
        //* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
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
