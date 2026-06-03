<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RecalculateWageEndDates extends Command
{
    protected $signature = 'wages:recalculate';
    protected $description = 'Recalculate wage end dates for all users';

    public function handle()
    {
        $users = User::has('wageHistory')->get();

        if ($users->isEmpty()) {
            $this->info('No users with wage history found.');
            return 0;
        }

        foreach ($users as $user) {
            $user->recalculateWageEndDates();
            $this->info("Recalculated wages for: {$user->name}");
        }

        $this->info('Done.');
        return 0;
    }
}
