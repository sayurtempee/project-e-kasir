<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeactivateInactiveMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:deactivate-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDate = now()->subDays(7);

        $affected = \App\Models\Member::where('status', 'active')
            ->where(function ($query) use ($expiredDate) {
                $query->whereNull('last_transaction_at')
                    ->orWhere('last_transaction_at', '<', $expiredDate);
            })
            ->update(['status' => 'inactive']);

        $this->info("Total member dinonaktifkan: $affected");
    }
}
