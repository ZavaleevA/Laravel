<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\SubCommentAds;
use App\Models\CommentAds;
use \DB;
use \Auth;

class SubCommentAdsController extends Controller
{
    public function newSubCommentAds($id){
        $subCommentAds = new CommentAds;
        return view('subCommentAds', ['dataCommentAds' => [$subCommentAds->find($id)]]);
    }

    public function addSubCommentAds(Request $req, $id){
        $sub_comment_ads = new SubCommentAds();
        if(($sub_comment_ads->text = $req->input('newSubComment')) == ''){
            return redirect()->back()->with('errorSubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $sub_comment_ads->text = $req->input('newSubComment');
            $sub_comment_ads->id_comment = $id;
            $sub_comment_ads->id_user = Auth::user()->id;
            $sub_comment_ads->id_sub_comment = NULL;
            $sub_comment_ads->created_at = date('Y-m-d H:i:s');
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
        if(($reply_sub_comment->text = $req->input('newReplySubComment')) == ''){
            return redirect()->back()->with('errorReplySubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $reply_sub_comment->text = $req->input('newReplySubComment');
            $reply_sub_comment->id_comment = DB::table('sub_comment_ads')->where('id', $id)->value('id_comment');
            $reply_sub_comment->id_user = Auth::user()->id;
            $reply_sub_comment->id_sub_comment = $id;
            $reply_sub_comment->created_at = date('Y-m-d H:i:s');
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