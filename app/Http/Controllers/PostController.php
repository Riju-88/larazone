<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
use App\Notifications\ActivityNotification;
use Carbon\Carbon;

class PostController extends Controller
{
    //
    // Display a list of posts in a thread
    public function index(Thread $thread)
    {
        $posts = $thread->posts;

        // Apply the global XSS clean method to each post
        foreach ($posts as $post) {
            $post->body = $this->global_xss_clean($post->body);
        }

        return view('posts.index', compact('posts', 'thread'));
    }

    public function global_xss_clean($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }


    // Show the form for creating a new post
    public function create(Thread $thread)
    {
        return view('posts.create', compact('thread'));
    }

    // Store a newly created post
    public function store(Request $request, Category $category, Thread $thread)
    {
        $request->validate([
            'content' => 'required',
            'files.*' => 'max:8192',
        ]);

        $post = new Post([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
        ]);

        // Handle file uploads and store their paths
        if ($request->hasFile('files')) {
            $filePaths = [];
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('uploads', 'public'); // Store files in the 'public' disk under the 'uploads' directory
                $filePaths[] = $filePath;
            }
            $post->files = json_encode($filePaths);
        }

        // Set the category_id and thread_id for the post
        $post->category_id = $category->id;
        $post->thread_id = $thread->id;

        // Save the post
        $post->save();




        // Send notification for new post

        $postUser = $post->user; // User who posted
        $threadUser = $post->thread->user; // User who created the thread

        $threadMsg = "<a href='" . route('threads.show', ['category' => $post->thread->category, 'thread' => $post->thread]) . "#post-{$post->id}'>$postUser->name posted on your thread.</a>";

        $subscriberMsg = "<a href='" . route('threads.show', ['category' => $post->thread->category, 'thread' => $post->thread]) . "#post-{$post->id}'>$postUser->name posted on $threadUser->name's thread.</a>";

        // Determine the subscribed users dynamically
        $subscribedUsers = $post->thread->category->subscribers;

        foreach ($subscribedUsers as $subscribedUser) {

            // Thread creator is not a subscriber and post creator is not thread creator
            if ($subscribedUser->isNot($threadUser) && $postUser->isNot($threadUser) && $subscribedUser->isNot($postUser)) {
                $subscribedUser->notify(new ActivityNotification('new_post', [
                    'post' => $post,
                    'message' => $subscriberMsg,
                ]));
            }
            // Delete notifications older than 7 days for subscribers
            $subscribedUser->notifications()
                ->where('created_at', '<', Carbon::now()->subDays(7))
                ->delete();
        }
        if ($postUser->isNot($threadUser)) {
            $threadUser->notify(new ActivityNotification('new_post', [
                'post' => $post,
                'message' => $threadMsg,
            ]));

            // Delete notifications older than 7 days for thread creator
            $threadUser->notifications()
                ->where('created_at', '<', Carbon::now()->subDays(7))
                ->delete();
        }


        // Redirect back to the thread
        return redirect()->route('threads.show', ['category' => $category, 'thread' => $thread]);
    }

    public function edit(Category $category, Thread $thread, Post $post)
    {
        return view('posts.edit', compact('category', 'thread', 'post'));
    }

    public function update(Request $request, Category $category, Thread $thread, Post $post)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('threads.show', ['category' => $category, 'thread' => $thread]);
    }



    public function upvote(Post $post)
    {
        $user = auth()->user();
        // Store the previous URL
        $previousUrl = url()->previous();
        if ($post->userUpvoted()) {
            // Cancel the upvote
            $post->decrement('upvotes');
            $post->upvoted_by = json_encode(array_diff(json_decode($post->upvoted_by), [$user->id]));
        } else {
            // Cancel any existing downvote
            if ($post->userDownvoted()) {
                $post->decrement('downvotes');
                $post->downvoted_by = json_encode(array_diff(json_decode($post->downvoted_by), [$user->id]));
            }

            $post->increment('upvotes');

            if ($post->upvoted_by === null) {
                $post->upvoted_by = json_encode([$user->id]);
            } else {
                $post->upvoted_by = json_encode(array_merge(json_decode($post->upvoted_by), [$user->id]));
            }
        }

        $post->save();

        return back();
    }

    public function downvote(Post $post)
    {
        $user = auth()->user();

        if ($post->userDownvoted()) {
            // Cancel the downvote
            $post->decrement('downvotes');
            $post->downvoted_by = json_encode(array_diff(json_decode($post->downvoted_by), [$user->id]));
        } else {
            // Cancel any existing upvote
            if ($post->userUpvoted()) {
                $post->decrement('upvotes');
                $post->upvoted_by = json_encode(array_diff(json_decode($post->upvoted_by), [$user->id]));
            }

            $post->increment('downvotes');

            if ($post->downvoted_by === null) {
                $post->downvoted_by = json_encode([$user->id]);
            } else {
                $post->downvoted_by = json_encode(array_merge(json_decode($post->downvoted_by), [$user->id]));
            }
        }

        $post->save();

        return back();
    }



    public function destroy(Category $category, Thread $thread, Post $post)
    {
        // Delete associated files
        $this->deleteFiles($post->files);

        // Delete the post
        $post->delete();

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
