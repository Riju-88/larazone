<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    // public function search(Request $request)
    // {
    //     $keyword = $request->input('search');

    //     $results = Thread::where(function ($query) use ($keyword) {
    //         $query->where('title', 'like', "%$keyword%")
    //               ->orWhere('content', 'like', "%$keyword%");
    //     })
    //     ->orWhereHas('posts', function ($query) use ($keyword) {
    //         $query->where('content', 'like', "%$keyword%");
    //     })
    //     ->get();

    //     return view('search.index', compact('results'));
    // }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $filter = $request->input('filter');
        $postResults = Post::where('content', 'like', "%$keyword%")->paginate(10);
       

        $threadResults = Thread::where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('content', 'like', "%$keyword%");
            })
            ->paginate(10);

             // Apply the filter if selected
        if ($filter === 'Thread') {
            $postResults = [];
        } elseif ($filter === 'Post') {
            $threadResults = [];
        } else {
            // No filter selected, display both threads and posts
          
        }
            // \Log::info("post search results:".$postResults);
        return view('search.index', compact('threadResults', 'postResults', 'keyword'));
    }

    // public function search(Request $request)
    // {
    //     $keyword = $request->input('search');
    //     $filter = $request->input('filter');
        
    //     // Initialize paginated result variables
    //     $threadResults = collect();
    //     $postResults = collect();
    
    //     if ($filter !== 'Post') {
    //         $threadResults = Thread::where(function ($query) use ($keyword) {
    //                 $query->where('title', 'like', "%$keyword%")
    //                     ->orWhere('content', 'like', "%$keyword%");
    //             })
    //             ->paginate(10);
    //     }
    
    //     if ($filter !== 'Thread') {
    //         $postResults = Post::where('content', 'like', "%$keyword%")->paginate(10);
    //     }
    
    //     return view('search.index', compact('threadResults', 'postResults', 'keyword'));
    // }
    
    
    


}
