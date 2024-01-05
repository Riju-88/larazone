<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
        return view('admin.dashboard', compact('categories'));
    }
    public function manageRoles()
    {
        $users = User::select('name', 'email', 'id', 'badge', 'profile_image', 'role')->get();


        foreach ($users as $user) {
            $user->upvotes = $user->posts()->sum('upvotes');
            $user->downvotes = $user->posts()->sum('downvotes');
        }

        return view('admin.roles.assign', compact('users'));
    }
    public function assignAdmin()
    {

     $admin = User::where('role', 'admin')->first();
     
     $user = User::findOrFail(request('user_id'));
     
     if ($admin) {
         $admin->badge = 'user';
         $admin->role = 'user';
         $admin->save();
     
         $user->role = 'admin';
         $user->badge = 'admin';
         $user->save();
     
         return back()->with('success', 'Admin transfer process completed successfully.');
     }
     
     return back()->with('error', 'Cannot assign more than one admin.');
    }
    public function assignMod()
    {


        $modCount = User::where('role', 'mod')->count();
        $user = User::findOrFail(request('user_id'));

        if (!in_array($user->role, ['mod', 'admin'])) {
            // Check if the current number of moderators is less than 5
            if ($modCount < 5) {
                $user->role = 'mod';
                $user->badge = 'mod';
                $user->save();
                return back()->with('success', 'User role updated successfully.');
            } else {
                return back()->with('error', 'Maximum number of moderators reached.');
            }
        } elseif ($user->role == 'admin') {
            return back()->with('error', 'Admin cannot be promoted to moderator.');
        } else {
            // Toggle the user back to 'user'
            $user->role = 'user';
            $user->badge = 'user';
            $user->save();
            $this->updateBadge();
            return back()->with('success', 'User role updated successfully.');
        }
        
    }
    public function userBadgeIndex()
    {
        $users = User::select('name', 'email', 'id', 'badge', 'profile_image')->get();


        foreach ($users as $user) {
            $user->upvotes = $user->posts()->sum('upvotes');
            $user->downvotes = $user->posts()->sum('downvotes');
        }

        return view('admin.badges.index', compact('users'));
    }



    public function updateBadge()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Find users whose accounts are <7 days old and exclude admin or mod users
        $newUsers = User::where('created_at', '>', $sevenDaysAgo)
            ->whereNotIn('badge', ['admin', 'mod'])
            ->get();
            
            // Find users whose accounts are 7+ days old and exclude admin or mod users
            // ->where('created_at', '<=', $sevenDaysAgo): This part of the query filters users based on the created_at column, checking if it is less than or equal to the timestamp of seven days ago. This condition ensures that you select users whose accounts were created 7 or more days ago.
        $usersToUpdate = User::where('created_at', '<=', $sevenDaysAgo)
            ->whereNotIn('badge', ['admin', 'mod'])
            ->get();

            foreach ($newUsers as $user) {
                // Update the badge based on conditions
                $badge = 'new user';

                // Update the badge value
                $user->badge = $badge;
                $user->save();
                
            }
        foreach ($usersToUpdate as $user) {
            // Update the badge based on conditions
            $badge = 'user';

            // Update the badge based on conditions
            $upvotes = $user->posts()->sum('upvotes');
            $downvotes = $user->posts()->sum('downvotes');
            $downvoteRatio = $downvotes > 0 ? ($downvotes / ($upvotes + $downvotes)) * 100 : 0;

            if ($upvotes >= 10 && $downvotes < 0.2 * $upvotes) {
                $badge = 'pro';
                // info("User {$user->id} badge set to 'pro' based on upvotes and downvote ratio.");
            } elseif ($downvotes >= 10 && $downvoteRatio > 50) {
                $badge = 'negative influencer';
                // info("User {$user->id} badge set to 'Negative Influencer' based on downvotes and downvote ratio.");
            }


            // Update the badge value
            $user->badge = $badge;
            $user->save();

            // Check if the save was successful
            // if (!$user->wasChanged()) {
            //     return back()->with('error', 'Failed to update user badges.');
            // }
        }

        return back()->with('success', 'User badges updated successfully.');
    }

    public function manageUsers(User $user)
    {
        $users = User::select('name', 'email', 'id', 'badge', 'profile_image','role')->get();
       
        foreach ($users as $user) {
            $user->upvotes = $user->posts()->sum('upvotes');
            $user->downvotes = $user->posts()->sum('downvotes');
        }
        return view('admin.users.index', compact('users'));
    }
    public function destroyUser(User $user)
    {
        try {
            // Log the user ID before deletion
            Log::info('Deleting user with ID: ' . $user->id);
    
            // Attempt to delete the user
            $user->delete();
    
            // Log a success message
            Log::info('User deleted successfully.');
    
            // Redirect back with a success message
            return back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error deleting user: ' . $e->getMessage());
    
            // Redirect back with an error message
            return back()->with('error', 'Error deleting user.');
        }
    }
}
