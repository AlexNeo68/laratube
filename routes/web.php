<?php

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

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VoteController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('channels', 'ChannelController');

Route::get('videos/{video}', [VideoController::class, 'show'])->name('videos.show');
Route::put('videos/{video}', [VideoController::class, 'views']);
Route::get('videos/{video}/comments', [CommentController::class, 'index']);
Route::get('comments/{comment}/replies', [CommentController::class, 'show']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('comments/{video}', [CommentController::class, 'store']);
    Route::resource('channels/{channel}/subscriptions', 'SubscriptionController', ['only' => ['store', 'destroy']])->middleware(['auth']);
    Route::get('channels/{channel}/videos', [UploadVideoController::class, 'index'])->name('channel.upload');
    Route::post('channels/{channel}/videos', [UploadVideoController::class, 'store']);
    Route::patch('videos/{video}/update', [VideoController::class, 'update'])->name('videos.update');
    Route::post('votes/{id}/{type}', [VoteController::class, 'vote'])->name('votes.vote');
});
