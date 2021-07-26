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

Route::get('/comments', function () {
    return view('comments');
});

Route::post('/validation_form/newUserDate', function () {
    return view('validation_form/newUserDate');
});

Route::get('/validation_form/deleteUserPhoto', function () {
    return view('validation_form/deleteUserPhoto');
});

Route::post('/image/upload', 'ImageController@upload')->name('image.upload');

Route::get('/image/delete', 'ImageController@delete')->name('image.delete');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');