<?php

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

Route::get('/', function () {
    return redirect()->route('threads.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/threads', [ThreadsController::class, 'index'])->name('threads.index');
Route::get('/threads/create', [ThreadsController::class, 'create'])->name('threads.create')->middleware('auth');
Route::get('/threads/{category:slug}', [ThreadsController::class, 'index']);
Route::post('/threads', [ThreadsController::class, 'store'])->name('threads.store')->middleware('auth');
Route::get('/threads/{category:slug}/{thread:id}', [ThreadsController::class, 'show'])->name('threads.show');
Route::post('/threads/{category:slug}/{thread:id}/replies', [RepliesController::class, 'store'])->middleware('auth');

require __DIR__ . '/auth.php';
