<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('register');
    // return redirect()->route('register.form');
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate user input, including the uploaded image
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed file types and size as needed
    ]);

    // Process image upload and store in a user-specific directory (you can customize the directory structure)
    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images/' . auth()->id(), 'public');
    }

    // Create the user
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'profile_image' => $imagePath ?? null,
    ]);

    // Log in the user or perform any other necessary actions
    auth()->login($user);

    // Redirect or perform other actions as needed
    return redirect()->route('login'); // Change 'home' to your intended post-registration route
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
