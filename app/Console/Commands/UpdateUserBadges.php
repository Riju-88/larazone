<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;

class UpdateUserBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-badges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user badge';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Find users whose accounts are 7+ days old
        $usersToUpdate = User::where('created_at', '<=', $sevenDaysAgo)->get();

        foreach ($usersToUpdate as $user) {
            // Update the badge based on conditions
            $badge = 'regular user';

            if ($user->posts()->sum('upvotes') >= 100) {
                $badge = 'pro';
            } elseif ($user->posts()->sum('downvotes') <= -50) {
                $badge = 'Negative Influence';
            }

            // Update the badge value
            $user->update(['badge' => $badge]);
        }

        $this->info('User badges updated successfully.');
    }
}
