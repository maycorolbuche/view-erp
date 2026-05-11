<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Helpers\ConfigHelper as Configs;

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
        Configs::set("cron.run.start", now());

        $schedule->command('task:close_authorizations')->dailyAt('00:00');
        $schedule->command('task:close_batches_without_refund')->dailyAt('00:00');

        $schedule->command('task:remove_inactive_expenses')->dailyAt('00:30');
        $schedule->command('task:email_pending_batches')->dailyAt('00:30');

        $schedule->command('task:migrate')->dailyAt('03:00');
        $schedule->command('task:seed')->dailyAt('03:00');
        $schedule->command('task:remove_old_logs')->dailyAt('04:00');

        $schedule->command('task:batch_approved_when_paid')->dailyAt('01:00');
        $schedule->command('task:delete_excess_files')->dailyAt('01:30');

        $schedule->command('task:backup')->dailyAt('23:00');

        Configs::set("cron.run.end", now());

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
