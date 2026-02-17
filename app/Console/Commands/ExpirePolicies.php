<?php

namespace App\Console\Commands;

use App\Models\Policy;
use Illuminate\Console\Command;

class ExpirePolicies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark active policies as expired when end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = now()->toDateString();

        $expiredCount = Policy::where('status', 'active')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => 'expired']);

        $this->info("Expired {$expiredCount} policies.");

        return Command::SUCCESS;
    }
}
