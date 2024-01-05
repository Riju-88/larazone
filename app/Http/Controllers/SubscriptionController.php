<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Category;
use App\Models\User;

class SubscriptionController extends Controller
{
    //
    public function subscribeCategory(Request $request, $categoryId)
    {
        $user = User::find(auth()->user()->id);
    
        // Check if the user is already subscribed to the category
        if (!$user->subscriptions()->where('category_id', $categoryId)->exists()) {
            Subscription::create([
                'user_id' => $user->id,
                'category_id' => $categoryId,
            ]);
    
            $categories = Category::all();
            return view('categories.index', compact('categories'))->with('success', 'Subscribed successfully');
        }
    
        $categories = Category::all();
        return view('categories.index', compact('categories'))->with('info', 'Already subscribed');
    }
    
    public function unsubscribeCategory(Request $request, $categoryId)
    {
        $user = User::find(auth()->user()->id);
    
        // Check if the user is subscribed to the category
        $subscription = $user->subscriptions()->where('category_id', $categoryId)->first();
    
        if ($subscription) {
            // Instead of deleting the subscription, detach it
            $user->subscriptions()->detach($subscription->id);
    
            $categories = Category::all();
            return view('categories.index', compact('categories'))->with('success', 'Unsubscribed successfully');
        }
    
        $categories = Category::all();
        return view('categories.index', compact('categories'))->with('info', 'Not subscribed');
    }
    
    
    
}
