<?php

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
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/sample', [App\Http\Controllers\Sample\IndexController::class, 'show']);
Route::get('/sample/{id}', [App\Http\Controllers\Sample\IndexController::class, 'showId']);
Route::get('/twitter', App\Http\Controllers\Twitter\IndexController::class)->name('tweet.index');

Route::middleware('auth')->group(function () {
    Route::post('/twitter/create', App\Http\Controllers\Twitter\CreateController::class)
        ->middleware('auth')
        ->name('tweet.create');

    Route::get('/twitter/update/{tweetId}', App\Http\Controllers\Twitter\Update\IndexController::class)
        ->name('tweet.update.index')->where('tweetId', '[0-9]+');
    Route::put('/twitter/update/{tweetId}', App\Http\Controllers\Twitter\Update\PutController::class)
        ->name('tweet.update.put')->where('tweetId', '[0-9]+');

    Route::delete('/twitter/delete/{tweetId}', App\Http\Controllers\Twitter\DeleteController::class)->name('tweet.delete');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
