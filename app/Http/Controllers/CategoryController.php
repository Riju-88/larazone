<?php

namespace App\Http\Controllers;
use App\Models\Category; // Adjust the namespace and path to match your project structure

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        $filter = Request()->input('filter');

        // \Log::info("all: ".$categories);
        if ($filter && $filter=== "following") {
            $categories = Category::whereHas('subscriptions', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->get();
            // \Log::info("following: ".$categories);
        }
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
    

    public function create()
    {
        // Show the form to create a new category
    }

    public function store(Request $request)
    {
        // Validate and store the new category
    }


    public function edit($id)
    {
        // Show the edit form for a category
    }

    public function update(Request $request, $id)
    {
        // Validate and update the category
    }

    public function destroy($id)
    {
        // Delete a category
    }
}
