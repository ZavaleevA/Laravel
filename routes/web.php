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

Route::get('/downloadNewPhoto', function () {
    return view('downloadNewPhoto');
});

Route::get('/addComment', function () {
    return view('addComment');
})->name('addComment');

Route::get('/comments', function () {
    return view('comments');
})->name('comments');

Route::get('/newUserDate', function () {
    return view('newUserDate');
})->name('newUserDate');

Route::post('/newUserDate/new', 'NewUserDateController@new')->name('new-user-date');

Route::get('/validation_form/deleteUserPhoto', function () {
    return view('validation_form/deleteUserPhoto');
});

Route::get('/comment/delete/{id}', 'CommentController@deleteComment')->name('comment-delete');

Route::get('/comment/dateEditComment/{id}', 'CommentController@dateEditComment')->name('comment-date-edit');

Route::post('/comment/editComment/{id}', 'CommentController@editComment')->name('comment-edit');

Route::get('/comment/all', 'CommentController@allData')->name('comment-data');

Route::post('/comment/submit', 'CommentController@submit')->name('comment-form');

Route::post('/image/upload', 'ImageController@upload')->name('image.upload');

Route::get('/image/delete', 'ImageController@delete')->name('image.delete');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');