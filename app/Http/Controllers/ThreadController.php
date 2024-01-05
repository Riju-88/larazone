<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use App\Models\User;
use App\Notifications\ActivityNotification;



class ThreadController extends Controller
{
    //
    public function index(Category $category)
    {
        $threads = Thread::where('category_id', $category->id)->orderByDesc('created_at')->paginate(10);
   
    
        return view('threads.index', compact('category', 'threads'));
    }
    

    

public function create(Category $category)
{
    return view('threads.create', ['category' => $category]);
}



public function store(Request $request, Category $category)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'files.*' => 'max:8192', // Limit file size to 5MB
    ]);

    $thread = new Thread([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

    // Associate the thread with the currently authenticated user
    $thread->user_id = auth()->user()->id;

    // Handle file uploads and store their paths
    if ($request->hasFile('files')) {
        $filePaths = [];
        foreach ($request->file('files') as $file) {
            $filePath = $file->store('uploads', 'public'); // Store files in the 'public' disk under the 'uploads' directory
            $filePaths[] = $filePath;
        }
        $thread->files = json_encode($filePaths);
    }

    // Associate the thread with the category
    $category->threads()->save($thread);
    
    // notifications
    $subscribedUsers = $category->subscribers;
    // $subscribedUsers = $category->subscribers();
    $message = "<a href='" . route('threads.show', ['category' => $thread->category, 'thread' => $thread]) . "'>" . $thread->user->name . " created a new thread.</a>";

    $adminUsers = User::whereIn('role', ['admin', 'mod'])->get();

    foreach ($adminUsers as $user) {
        if ($user->id != $thread->user_id) {
             // Send notification for new thread
        $user->notify (new ActivityNotification ('new_thread', ['user' => $user, 'message' => $message]));
        }
      
    }
    // Check if there are subscribed users before proceeding
    if ($subscribedUsers !== false && $subscribedUsers !== null) {
        foreach ($subscribedUsers as $user) {
            if ($user->role != 'admin' && $user->role != 'mod') {
                if ($user->id != $thread->user_id) {
                      // Send notification for new thread
              
                 $user->notify (new ActivityNotification ('new_thread', ['user' => $user, 'message' => $message]));
                }
            
            }
           
        //  \Log::info("user result: " . $user);
          
        }
    }
    
    
    return redirect()->route('category.threads.index', ['category' => $category]);
}

public function show(Category $category, Thread $thread)
{
    // Eager load the posts relationship with pagination
    $posts = $thread->posts()->orderByDesc('created_at')->paginate(10);

    return view('threads.show', compact('category', 'thread', 'posts'));
}



public function feed()
{
    // Retrieve the latest 4 threads with their associated category
    $recentThreads = Thread::with('category')->latest()->take(4)->get();
    // $subbedCategories = Category::whereHas('subscribers', function ($query) {
    //     $query->where('user_id', auth()->user()->id);
    // })
    // ->latest()
    // ->take(4)
    // ->get();
    $subbedCategories = Category::join('subscriptions', 'categories.id', '=', 'subscriptions.category_id')
    ->where('subscriptions.user_id', auth()->user()->id)
    ->latest('subscriptions.created_at') // Replace 'created_at' with the actual column you want to use
    ->take(4)
    ->get();

// \Log::info("subbed Categories: ".$subbedCategories);
    // Pass the recent threads to the dashboard view
    return view('dashboard', compact('recentThreads', 'subbedCategories'));
}
public function edit(Category $category, Thread $thread)
{
    return view('threads.edit', ['category' => $category, 'thread' => $thread]);
}

public function update(Request $request, Category $category, Thread $thread)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

   $thread->update($validatedData);

    return redirect()->route('threads.show', ['category' => $category, 'thread' => $thread])->with('success', 'Thread updated successfully.');
}




public function destroy(Thread $thread)
{
    $thread->delete();

    return redirect()->route('categories.index')->with('success', 'Thread deleted successfully.');
}

}
