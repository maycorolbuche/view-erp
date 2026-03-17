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
        // php artisan schedule:run

        $schedule->command('task:close_authorizations')->daily();
        $schedule->command('task:close_batches_without_refund')->daily();

        $schedule->command('task:remove_inactive_expenses')->daily();
        $schedule->command('task:email_pending_batches')->daily();

        $schedule->command('task:migrate')->daily();
        $schedule->command('task:seed')->daily();
        $schedule->command('task:remove_old_logs')->daily();

        $schedule->command('task:batch_approved_when_paid')->daily();
        $schedule->command('task:delete_excess_files')->daily();

        $schedule->command('task:backup')->daily();

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
