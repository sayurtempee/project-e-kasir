<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Daftarkan jadwal di sini
        $schedule->command('members:deactivate-inactive')->daily();
    }

    protected function commands(): void
    {
        // WAJIB: Load command dari app/Console/Commands
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
