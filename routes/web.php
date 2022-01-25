<?php

use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// home
Route::get('/', function () {
    return redirect()->route('threads.index');
});


Route::group(['middleware' => ['auth']], function () {

    // dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // threads
    Route::resource('threads', ThreadsController::class)->except(['show', 'index']);

    // replies
    Route::post('/threads/{category:slug}/{thread:slug}/replies', [RepliesController::class, 'store'])->name('replies.store');

    // likes
    Route::post('/replies/{reply:id}/likes', [LikesController::class, 'store']);
});


// threads
Route::get('/threads', [ThreadsController::class, 'index'])->name('threads.index');
Route::get('/threads/{category:slug}', [ThreadsController::class, 'index']);
Route::get('/threads/{category:slug}/{thread}', [ThreadsController::class, 'show'])->name('threads.show');

// profiles
Route::get('/profiles/{user:name}', [ProfileController::class, 'show']);


require __DIR__ . '/auth.php';
