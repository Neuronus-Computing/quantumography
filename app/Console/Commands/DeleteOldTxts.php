<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TextPass;
use Carbon\Carbon;

class DeleteOldTxts extends Command
{
    protected $signature = 'delete:oldTxts';
    protected $description = 'Delete text records created three months ago or more.';

    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        TextPass::where('created_at', '<', $threeMonthsAgo)->delete();

        $this->info('Old text records deleted successfully.');
    }
}
