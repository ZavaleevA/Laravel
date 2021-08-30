<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\CommentAds;
use \DB;
use \Auth;

class CommentAdsController extends Controller
{
    public function addCommentAds(CommentRequest $req, $id){
        $comment = new CommentAds();
        $comment->user_id = Auth::user()->id;
        $comment->ads_id = $id;
        $comment->text = $req->input('comment');
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->updated_at = NULL;
        $comment->save();
        return redirect()->back()->with('success', 'Комментарий был добавлен');
    }

    public function deleteCommentAds($id){
        DB::delete('delete from comment_ads where id = ?',[$id]);
        DB::delete('delete from sub_comment_ads where id_comment = ?',[$id]);
        return redirect()->back()->with('success', 'Комментарий был удален!');
    }

    public function dateEditCommentAds($id){
        $comment = new CommentAds;
        return view('editCommentAds', ['data' => [$comment->find($id)]]);
    }

    public function editCommentAds(CommentRequest $newText, $id){
        if (($oldText = DB::table('comment_ads')->where('id', $id)->value('text')) != ($updateText = $newText->input('comment'))){
                DB::table('comment_ads')
                ->where('id',$id)
                ->update(['text' => $updateText, 'updated_at' => date('Y-m-d H:i:s')]);
                return redirect()->back()->with('editSuccess', 'Комментарий отредактирован');
        } else {
            return redirect()->back()->with('editError', 'Комментарий не изменился');
        }   
    }
}
