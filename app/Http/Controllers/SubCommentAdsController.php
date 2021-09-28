<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\SubCommentAds;
use App\Models\CommentAds;
use Illuminate\Support\HtmlString;
use \DB;
use \Auth;
use Mail;

class SubCommentAdsController extends Controller
{
    public function newSubCommentAds($id){
        $subCommentAds = new CommentAds;
        return view('subCommentAds', ['dataCommentAds' => [$subCommentAds->find($id)]]);
    }

    public function addSubCommentAds(Request $req, $id){
        $sub_comment_ads = new SubCommentAds(); 
        $textSubComment = $req->input('newSubComment');
        if(($sub_comment_ads->text = $textSubComment) == ''){
            return redirect()->back()->with('errorSubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $adsId = DB::table('comment_ads')->where('id', $id)->value('ads_id');            
            $dateSubComment = date('Y-m-d H:i:s');
            $dateForEmail = date('d.m.y ⌚H:i');
            $textComment = DB::table('comment_ads')->where('id', $id)->value('text');
            $dateComment = DB::table('comment_ads')->where('id', $id)->value('created_at');
            $idUserAnswer = DB::table('comment_ads')->where('id', $id)->value('user_id');
            $nameUserAnswer = DB::table('users')->where('id', $idUserAnswer)->value('name');
            $emailUserAnswer = DB::table('users')->where('id', $idUserAnswer)->value('email');
            $nameUser = Auth::user()->name;
            $urlCommenta = 'http://laravel/public/parsing/dateAds/' . $adsId;
            
            $textForEmail = '📬' . $nameUserAnswer . ', на Ваш комментарий ответил(а) ' . $nameUser . '!' . "\n\n" . 
            '✅----------------------------------------✅' . "\n" . 
            '📝Ваш комментарий:' . "\n" . 
            '"' . $textComment . '"' . "\n" . 
            '⏰Сообщение отправлено: ' . $dateComment . "\n" . 
            '✅----------------------------------------✅' . "\n\n" . 
            '🔥----------------------------------------🔥' . "\n" . 
            '📩' . $nameUser . ' дал(а) ответ:' . "\n" . 
            '"' . $textSubComment . '"' . "\n" . 
            '⏰Сообщение отправлено: ' . $dateForEmail . "\n" . 
            '🔥----------------------------------------🔥' . "\n\n" . 
            '⚡Чтобы перейти на стрницу с комментарием, нажмите на ссылку ниже:' . "\n" . $urlCommenta;

            $data = array( 'email' => $emailUserAnswer, 'first_name' => 'Laravel ads Daewoo', 'from' => 'zavaleev.sbase@gmail.com', 'from_name' => 'learming', 'textMessege' => $textForEmail);

            Mail::send( [], $data, function( $message ) use ($data) {
                $message->to( $data['email'] )->from( $data['from'], 
                $data['first_name'] )->subject( '📬Вам ответили на комментарий!' )->setBody($data['textMessege']);
            });

            $sub_comment_ads->text = $textSubComment;
            $sub_comment_ads->id_comment = $id;
            $sub_comment_ads->id_user = Auth::user()->id;
            $sub_comment_ads->id_sub_comment = NULL;
            $sub_comment_ads->created_at = $dateSubComment;
            $sub_comment_ads->updated_at = NULL;
            $sub_comment_ads->save();
            return redirect()->back()->with('successSubComment', 'Ответ на комментарий был добавлен');
        }      
    }

    public function deleteSubCommentAds($id){
            DB::delete('delete from sub_comment_ads where id = ?',[$id]);
            DB::delete('delete from sub_comment_ads where id_sub_comment = ?',[$id]);
        return redirect()->back()->with('success', 'Комментарий удален');
    }

    public function dataEditSubCommentAds($id){
        $subCommentAds = new SubCommentAds;
        return view('editSubCommentAds', ['data' => [$subCommentAds->find($id)]]);
    }

    public function editSubCommentAds(CommentRequest $newText, $id){
        if (($oldText = DB::table('sub_comment_ads')->where('id', $id)->value('text')) != ($updateText = $newText->input('comment'))){
            DB::table('sub_comment_ads')
                ->where('id',$id)
                ->update(['text' => $updateText, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->back()->with('editSuccess', 'Комментарий отредактирован');
        } else {
            return redirect()->back()->with('editError', 'Комментарий не изменился');
        }    
    } 

    public function dataSubCommentAds($id){
        $subCommentAds = new SubCommentAds;
        return view('replyToSubCommentAds', ['data' => [$subCommentAds->find($id)]]);
    }

    public function addReplySubCommentAds(Request $req, $id){
        $reply_sub_comment = new SubCommentAds();
        $textSubComment = $req->input('newReplySubComment');
        if(($reply_sub_comment->text = $textSubComment) == ''){
            return redirect()->back()->with('errorReplySubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $idCommentAds = DB::table('sub_comment_ads')->where('id', $id)->value('id_comment');
            $adsId = DB::table('comment_ads')->where('id', $idCommentAds)->value('ads_id');
            $dateSubComment = date('Y-m-d H:i:s');
            $dateForEmail = date('d.m.y ⌚H:i');
            $textComment = DB::table('sub_comment_ads')->where('id', $id)->value('text');
            $dateComment = DB::table('sub_comment_ads')->where('id', $id)->value('created_at');
            $idUserAnswer = DB::table('sub_comment_ads')->where('id', $id)->value('id_user');
            $nameUserAnswer = DB::table('users')->where('id', $idUserAnswer)->value('name');
            $emailUserAnswer = DB::table('users')->where('id', $idUserAnswer)->value('email');
            $nameUser = Auth::user()->name;
            $urlCommenta = 'http://laravel/public/parsing/dateAds/' . $adsId;
            
            $textForEmail = '📬' . $nameUserAnswer . ', на Ваш комментарий ответил(а) ' . $nameUser . '!' . "\n\n" . 
            '✅----------------------------------------✅' . "\n" . 
            '📝Ваш комментарий:' . "\n" . 
            '"' . $textComment . '"' . "\n" . 
            '⏰Сообщение отправлено: ' . $dateComment . "\n" . 
            '✅----------------------------------------✅' . "\n\n" . 
            '🔥----------------------------------------🔥' . "\n" . 
            '📩' . $nameUser . ' дал(а) ответ:' . "\n" . 
            '"' . $textSubComment . '"' . "\n" . 
            '⏰Сообщение отправлено: ' . $dateForEmail . "\n" . 
            '🔥----------------------------------------🔥' . "\n\n" . 
            '⚡Чтобы перейти на стрницу с комментарием, нажмите на ссылку ниже:' . "\n" . $urlCommenta;

            $data = array( 'email' => $emailUserAnswer, 'first_name' => 'Laravel ads Daewoo', 'from' => 'zavaleev.sbase@gmail.com', 'from_name' => 'learming', 'textMessege' => $textForEmail);

            Mail::send( [], $data, function( $message ) use ($data) {
                $message->to( $data['email'] )->from( $data['from'], 
                $data['first_name'] )->subject( '📬Вам ответили на комментарий!' )->setBody($data['textMessege']);
            });

            $reply_sub_comment->text = $textSubComment;
            $reply_sub_comment->id_comment = $idCommentAds;
            $reply_sub_comment->id_user = Auth::user()->id;
            $reply_sub_comment->id_sub_comment = $id;
            $reply_sub_comment->created_at = $dateSubComment;
            $reply_sub_comment->updated_at = NULL;
            $reply_sub_comment->save();
            return redirect()->back()->with('successReplySubComment', 'Ответ на комментарий был добавлен');
        }     
    }

    public function deleteReplySubCommentAds($id){
            DB::delete('delete from sub_comment_ads where id = ?',[$id]);
        return redirect()->back()->with('success', 'Комментарий удален');
    }

    public function dateReplySubCommentAds($id){
        $subComment = new SubCommentAds;
        return view('editSubCommentAds', ['data' => [$subComment->find($id)]]);
    }
}