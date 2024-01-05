<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\ActivityNotification;
use Carbon\Carbon;

class AdminCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'required|unique:categories|max:500',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Notify all users about the new category
        User::all()->each(function ($user) use ($category) {
            $user->notify(new ActivityNotification('new_category', [
                'category' => $category,
                'user' => auth()->user(), // Assuming the currently authenticated user created the category
            ]));

            $user->notifications()
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->delete();
        });

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
{
    return view('admin.categories.edit', compact('category'));
}
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:500',
        ]);

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
}


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
