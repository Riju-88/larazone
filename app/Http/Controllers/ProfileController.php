<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // If the user is not authenticated via Google, perform password validation
    if (!auth()->user()->google_id) {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
    }

        $user = $request->user();

          
            // Delete the old profile image, if it exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
           
        
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile image.
     */
    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => 'image|mimes:jpeg,png,jpg,jfif,webp|max:4096', // Validate the profile image
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Check if the request has a file
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image, if it exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-image-updated');
    }

    // view user
public function viewUser(User $user)
{
    // $user = User::find($user->id);
    $threads = $user->threads()->paginate(10);
    $posts = $user->posts()->paginate(10);
return view('view_user.show', compact('user','threads','posts'));
}

}
