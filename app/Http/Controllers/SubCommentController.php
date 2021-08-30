<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\SubComment;
use App\Models\Comment;
use \DB;
use \Auth;

class SubCommentController extends Controller
{
    public function newSubComment($id){
        $subComment = new Comment;
        return view('subComment', ['data' => [$subComment->find($id)]]);
    }

    public function addSubComment(Request $req, $id){
        $sub_comment = new SubComment();
        if(($sub_comment->text = $req->input('newSubComment')) == ''){
            return redirect()->back()->with('errorSubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $sub_comment->text = $req->input('newSubComment');
            $sub_comment->id_comment = $id;
            $sub_comment->id_user = Auth::user()->id;
            $sub_comment->id_sub_comment = NULL;
            $sub_comment->created_at = date('Y-m-d H:i:s');
            $sub_comment->updated_at = NULL;
            $sub_comment->save();
            return redirect()->back()->with('successSubComment', 'Ответ на комментарий был добавлен');
        }      
    }

    public function deleteSubComment($id){
            DB::delete('delete from sub_comments where id = ?',[$id]);
            DB::delete('delete from sub_comments where id_sub_comment = ?',[$id]);
        return redirect()->back()->with('success', 'Комментарий удален');
        }

    public function dateEditSubComment($id){
        $subComment = new SubComment;
        return view('editSubComment', ['data' => [$subComment->find($id)]]);
    }

    public function editSubComment(CommentRequest $newText, $id){
        if (($oldText = DB::table('sub_comments')->where('id', $id)->value('text')) != ($updateText = $newText->input('comment'))){
            DB::table('sub_comments')
                ->where('id',$id)
                ->update(['text' => $updateText, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->back()->with('editSuccess', 'Комментарий отредактирован');
        } else {
            return redirect()->back()->with('editError', 'Комментарий не изменился');
        }    
    } 

    public function dateSubComment($id){
        $subComment = new SubComment;
        return view('replyToSubComment', ['data' => [$subComment->find($id)]]);
    }   

    public function addReplySubComment(Request $req, $id){
        $reply_sub_comment = new SubComment();
        if(($reply_sub_comment->text = $req->input('newReplySubComment')) == ''){
            return redirect()->back()->with('errorReplySubComment', 'Ответ на комментарий не был добавлен');
        } else {
            $reply_sub_comment->text = $req->input('newReplySubComment');
            $reply_sub_comment->id_comment = DB::table('sub_comments')->where('id', $id)->value('id_comment');
            $reply_sub_comment->id_user = Auth::user()->id;
            $reply_sub_comment->id_sub_comment = $id;
            $reply_sub_comment->created_at = date('Y-m-d H:i:s');
            $reply_sub_comment->updated_at = NULL;
            $reply_sub_comment->save();
            return redirect()->back()->with('successReplySubComment', 'Ответ на комментарий был добавлен');
        }      
    }

    public function deleteReplySubComment($id){
            DB::delete('delete from sub_comments where id = ?',[$id]);
        return redirect()->back()->with('success', 'Комментарий удален');
<<<<<<< HEAD
    }
=======
    } 
>>>>>>> 5b9de7c81f13a8a830709d6d5600b81318a874c5

    public function dateReplySubComment($id){
        $subComment = new SubComment;
        return view('editSubComment', ['data' => [$subComment->find($id)]]);
    } 
 
}
