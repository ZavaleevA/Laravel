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

Route::get('/parsing', function () {
    return view('parsing');
})->name('parsing');

Route::get('/feedback', function () {
    return view('feedback');
})->name('feedback');

Route::get('/ads', function () {
    return view('ads');
})->name('ads');

Route::get('/newUserDate', function () {
    return view('newUserDate');
})->name('newUserDate');

Route::get('/subComment', function () {
    return view('subComment');
})->name('subComment');

Route::get('/editSubComment', function () {
    return view('editSubComment');
})->name('editSubComment');

Route::get('/replyToSubComment', function () {
    return view('replyToSubComment');
})->name('replyToSubComment');

Route::get('/individualAds', function () {
    return view('individualAds');
})->name('individualAds');

Route::get('/parsing/allDataParsing', 'ParsingController@allDataParsing')->name('all-data-parsing');

Route::get('/parsing/dateAds/{id}', 'ParsingController@dateAds')->name('date-ads');

Route::get('/parsing/sortByDate/{specialToken}', 'ParsingController@sortByDate')->name('sort-by-date');

Route::get('/parsing/sortFromDear/{specialToken}', 'ParsingController@sortFromDear')->name('sort-from-dear');

Route::get('/parsing/sortFromCheap/{specialToken}', 'ParsingController@sortFromCheap')->name('sort-from-cheap');

Route::get('/parsing/sortFromNew/{specialToken}', 'ParsingController@sortFromNew')->name('sort-from-new');

Route::get('/parsing/sortFromOld/{specialToken}', 'ParsingController@sortFromOld')->name('sort-from-old');

Route::get('/parsing/sortByMileage/{specialToken}', 'ParsingController@sortByMileage')->name('sort-by-mileage');

Route::get('/parsing/filterAds', 'ParsingController@filterAds')->name('filter-ads');

Route::post('/parsing/newParsing', 'ParsingController@newParsing')->name('new-parsing');

Route::get('/parsing/updateParsing', 'ParsingController@updateParsing')->name('update-parsing');

Route::post('/newUserDate/new', 'NewUserDateController@new')->name('new-user-date');

Route::get('/comment/delete/{id}', 'CommentController@deleteComment')->name('comment-delete');

Route::get('/commentAds/delete/{id}', 'CommentAdsController@deleteCommentAds')->name('comment-ads-delete');

Route::get('/comment/dateEditComment/{id}', 'CommentController@dateEditComment')->name('comment-date-edit');

Route::get('/commentAds/dateEditCommentAds/{id}', 'CommentAdsController@dateEditCommentAds')->name('comment-ads-date-edit');

Route::get('/subComment/newSubComment/{id}', 'SubCommentController@newSubComment')->name('new-sub-comment');

Route::get('/subCommentAds/newSubCommentAds/{id}', 'SubCommentAdsController@newSubCommentAds')->name('new-sub-comment-ads');

Route::get('/subComment/deleteSubComment/{id}', 'SubCommentController@deleteSubComment')->name('delete-sub-comment');

Route::get('/subCommentAds/deleteSubCommentAds/{id}', 'SubCommentAdsController@deleteSubCommentAds')->name('delete-sub-comment-ads');

Route::get('/subComment/dateEditSubComment/{id}', 'SubCommentController@dateEditSubComment')->name('date-edit-sub-comment');

Route::get('/subCommentAds/dataEditSubCommentAds/{id}', 'SubCommentAdsController@dataEditSubCommentAds')->name('data-edit-sub-comment-ads');

Route::post('/subComment/editSubComment/{id}', 'SubCommentController@editSubComment')->name('edit-sub-comment');

Route::post('/subCommentAds/editSubCommentAds/{id}', 'SubCommentAdsController@editSubCommentAds')->name('edit-sub-comment-ads');

Route::get('/subComment/dateSubComment/{id}', 'SubCommentController@dateSubComment')->name('date-sub-comment');

Route::get('/subCommentAds/dataSubCommentAds/{id}', 'SubCommentAdsController@dataSubCommentAds')->name('data-sub-comment-ads');

Route::get('/subComment/deleteReplySubComment/{id}', 'SubCommentController@deleteReplySubComment')->name('delete-reply-sub-comment');

Route::get('/subCommentAds/deleteReplySubCommentAds/{id}', 'SubCommentAdsController@deleteReplySubCommentAds')->name('delete-reply-sub-comment-ads');

Route::get('/subComment/dateReplySubComment/{id}', 'SubCommentController@dateReplySubComment')->name('date-reply-sub-comment');

Route::get('/subCommentAds/dateReplySubCommentAds/{id}', 'SubCommentAdsController@dateReplySubCommentAds')->name('date-reply-sub-comment-ads');

Route::post('/subComment/addReplySubComment/{id}', 'SubCommentController@addReplySubComment')->name('add-reply-sub-comment');

Route::post('/subCommentAds/addReplySubCommentAds/{id}', 'SubCommentAdsController@addReplySubCommentAds')->name('add-reply-sub-comment-ads');

Route::post('/subComment/addSubComment/{id}', 'SubCommentController@addSubComment')->name('add-sub-comment');

Route::post('/subCommentAds/addSubCommentAds/{id}', 'SubCommentAdsController@addSubCommentAds')->name('add-sub-comment-ads');

Route::post('/comment/editComment/{id}', 'CommentController@editComment')->name('comment-edit');

Route::post('/commentAds/editCommentAds/{id}', 'CommentAdsController@editCommentAds')->name('comment-ads-edit');

Route::get('/comment/all', 'CommentController@allData')->name('comment-data');

Route::post('/comment/submit', 'CommentController@submit')->name('comment-form');

Route::post('/commentAds/addCommentAds/{id}', 'CommentAdsController@addCommentAds')->name('add-comment-ads');

Route::post('/feedback/dataFeedback', 'FeedbackController@dataFeedback')->name('data-feedback');

Route::post('/image/upload', 'ImageController@upload')->name('image.upload');

Route::get('/image/delete', 'ImageController@delete')->name('image.delete');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');