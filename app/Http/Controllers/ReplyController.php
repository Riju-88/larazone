<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
use App\Models\Reply;
use App\Notifications\ActivityNotification;
use App\Models\User;

class ReplyController extends Controller
{
    //
    public function create(Post $post)
{
    return view('replies.create', compact('post'));
}

public function store(Request $request, Category $category, Thread $thread, Post $post)
{
    $request->validate([
        'content' => 'required',
    ]);

   

    $reply = new Reply([
        'content' => $request->input('content'),
        'post_id' => $post->id,
        'user_id' => auth()->user()->id,
        'category_id' => $category->id,
        'thread_id' => $thread->id,
    ]);

       // Handle file uploads and store their paths
       if ($request->hasFile('filesR')) {
        $filePaths = [];
        foreach ($request->file('filesR') as $file) {
            $filePath = $file->store('uploads/replies', 'public');
            // Store files in the 'public' disk under the 'uploads' directory
            $filePaths[] = $filePath;
        }
        $reply->files = json_encode($filePaths);
    }

    $reply->save();

    // Notify the OP of the post about the new reply
    if ($post->user->id !== auth()->user()->id) {
        $post->user->notify(new ActivityNotification('new_reply', [
            'reply' => $reply,
            'user' => auth()->user(),
        ]));
    }
    
    return redirect()->route('threads.show', ['category' => $category, 'thread' => $thread]);
    // return view('threads.show', ['category' => $category, 'thread' => $thread]);

}

// Add methods for editing and deleting replies

public function destroy(Category $category, Thread $thread, Post $post,Reply $reply)
{
     // Delete associated files
     $this->deleteFiles($reply->files);

    $reply->delete();
    return redirect()->route('threads.show', ['category' => $category, 'thread' => $thread]);

}
private function deleteFiles($filePaths)
{
    if (!empty($filePaths)) {
        foreach ($filePaths as $filePath) {
            $fullPath = public_path('storage/' . $filePath);

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
}
