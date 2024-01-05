<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SearchController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about.index');
})->name('about.index');

Route::get('/dashboard', [ThreadController::class, 'feed'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     // New route for updating the profile image
     Route::patch('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update_image');
});



// Route::resource('categories', CategoryController::class);
Route::resource('categories', CategoryController::class);

// Route to list all categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Route to display individual category details
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// admin/mod routes
Route::middleware(['auth', 'admin'])->group(function () {

    // route for admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // route for admin categories
    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    
    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::patch('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // route for all reports
    Route::get('/admin/manage-reports', [ReportController::class, 'index'])->name('admin.reports.index');

    Route::delete('/admin/delete-report/{report_id}/{id}/{type}', [ReportController::class, 'delete'])->name('admin.reports.delete');
    Route::patch('/admin/manage-reports/{id}/update-status', [ReportController::class, 'updateStatus'])->name('admin.reports.updateStatus');

    // routes for managing user badges
    Route::get('/admin/manage-user-badges', [AdminController::class, 'userBadgeIndex'])->name('admin.badges.index');
    Route::post('/admin/manage-user-badges', [AdminController::class, 'updateBadge'])->name('admin.updateUserBadges');

    // routes for managing user roles
    Route::get('/admin/manage-roles', [AdminController::class, 'manageRoles'])->name('admin.roles.assign');
    Route::post('/admin/manage-roles', [AdminController::class, 'assignMod'])->name('admin.assignMod');
    Route::post('/admin/transfer-administration', [AdminController::class, 'assignAdmin'])->name('admin.assign_admin');

    // routes for deleting users
    Route::delete('/admin/delete-user/{user}', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');

    // route for user list
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
});

// Route::resource('threads', ThreadController::class);
// Route::resource('threads.posts', PostController::class)->shallow();

// Routes for managing threads and posts (accessible to all users)


// Routes for viewing posts within threads
Route::get('/categories/{category}/threads/{thread}/posts', [PostController::class, 'index'])->name('category.thread.posts.index');

Route::get('/categories/{category}/threads/{thread}/posts/create', [PostController::class, 'create'])->name('category.thread.posts.create');

Route::post('/categories/{category}/threads/{thread}/posts', [PostController::class, 'store'])->name('category.thread.posts.store');

Route::get('/categories/{category}/threads/{thread}/posts/{post}/edit', [PostController::class, 'edit'])->name('category.thread.posts.edit');

Route::patch('/categories/{category}/threads/{thread}/posts/{post}', [PostController::class, 'update'])->name('category.thread.posts.update');

Route::delete('/categories/{category}/threads/{thread}/posts/{post}', [PostController::class, 'destroy'])->name('category.thread.posts.destroy');


// Threads
// Routes for viewing threads within categories
Route::get('/categories/{category}/threads', [ThreadController::class, 'index'])->name('category.threads.index');
Route::get('/categories/{category}/threads/create', [ThreadController::class, 'create'])->name('category.threads.create');
Route::post('/categories/{category}/threads', [ThreadController::class, 'store'])->name('category.threads.store');

// Route to display individual thread details
Route::get('/categories/{category}/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::get('/categories/{category}/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');

Route::post('/categories/{category}/threads/{thread}/edit', [ThreadController::class, 'update'])->name('threads.update');

Route::delete('/categories/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.thread.destroy');

// reply routes
Route::post('/categories/{category}/threads/{thread}/posts/{post}/replies', [ReplyController::class, 'store'])->name('category.thread.posts.replies.store');

Route::delete('/categories/{category}/threads/{thread}/posts/{post}/replies/{reply}', [ReplyController::class, 'destroy'])->name('category.thread.posts.replies.destroy');

// upvote and downvotes
Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');

// report route
Route::post('/{type}/{id}/report', [ReportController::class, 'report'])->name('report');

// subscription routes
// Subscribe to a category
Route::post('/categories/subscribe/{categoryId}', [SubscriptionController::class, 'subscribeCategory'])->name('categories.subscribe');

// Unsubscribe from a category
Route::post('/categories/unsubscribe/{categoryId}', [SubscriptionController::class, 'unsubscribeCategory'])->name('categories.unsubscribe');

// search route
Route::get('/search', [SearchController::class, 'search'])->name('search.index');

// route for viewing profile of a user
Route::get('/view/profile/{user}', [ProfileController::class, 'viewUser'])->name('view_user.show');

// routes for social authentication

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

// Route::get('/auth/callback', function () {
//     $user = Socialite::driver('google')->user();

//     // Handle the user data obtained from Google
//     // You can use this $user object to extract information such as $user->id, $user->name, $user->email, etc.

//     // Now, you can check if the user already exists in your database or create a new user
//     $existingUser = User::where('email', $user->email)->first();

//     if ($existingUser) {
//         // Log in the existing user
//         Auth::login($existingUser);
//     } else {
//         // Create a new user
//         $newUser = User::create([
//             'name' => $user->name,
//             'email' => $user->email,
//             'google_id' => $user->id, // Add a field to your users table to store Google ID
//             'password' => Hash::make(Str::random(16)), // Optional: You might not need a password for social logins
//         ]);

//         Auth::login($newUser);
//     }

//     return redirect(RouteServiceProvider::HOME);
// });

Route::get('/auth/callback', function () {
    try {
        $user = Socialite::driver('google')->stateless()->user();

        // Handle the user data obtained from Google
        // You can use this $user object to extract information such as $user->id, $user->name, $user->email, etc.

        // Now, you can check if the user already exists in your database or create a new user
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // Log in the existing user
            Auth::login($existingUser);
        } else {
            // Create a new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id, // Add a field to your users table to store Google ID
                'password' => Hash::make(Str::random(16)), // Optional: You might not need a password for social logins
                
            ]);

            if ($user->avatar) {
                // Save the Google avatar URL as profile_image
                $path = 'profile_images/' . $newUser->id . '.jpg'; // You can customize the path as needed
                Storage::disk('public')->put($path, file_get_contents($user->avatar));
                $newUser->profile_image = $path;
            }
            $newUser->save();
            Auth::login($newUser);
        }

        return redirect(RouteServiceProvider::HOME);
    } catch (\Exception $e) {
        // Handle any exceptions, such as InvalidStateException
        // Log or redirect as needed
        return redirect('/'); // Change this to your error handling route
    }
});

require __DIR__ . '/auth.php';
