<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\UserProfileController;

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

Route::get('/search', SearchController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/user-profile/{user:username}',
    [UserProfileController::class, 'index']
)
    ->name('user-profile');
Route::get(
    '/user-profile/{user:username}/edit',
    [UserProfileController::class, 'edit']
)
    ->name('profile.edit');
Route::patch(
    '/user-profile/{user:username}',
    [UserProfileController::class, 'update']
)
    ->name('profile.update');

Route::post('/toggleLike/{post}', [LikeController::class, 'toggleLike']);
Route::post('/toggle-follow', [UserFollowController::class, 'toggleFollow'])
    ->name('toggleFollow');

Route::resource('/posts', PostController::class);
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('posts.comments.store');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('hasSetUsername');
Route::get('/explore', [ExploreController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('explore');
Route::get('/community', [CommunityPostController::class, 'index'])
    ->name('community');

Route::get(
    '/auth/{provider}/redirect',
    [SocialAuthController::class, 'redirectToProvider']
);
Route::get(
    '/auth/{provider}/callback',
    [SocialAuthController::class, 'handleProviderCallback']
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
