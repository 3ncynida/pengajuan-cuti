<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Reset monthly quotas (cuti haid)
        $schedule->command('leave:reset-monthly')
            ->monthlyOn(1, '00:00');

        // Reset annual quotas
        $schedule->command('leave:reset-annual')
            ->yearlyOn(1, 1, '00:00'); // January 1st at midnight
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}