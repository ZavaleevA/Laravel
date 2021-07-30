<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use \DB;
use \Auth;

class CommentController extends Controller
{
    public function submit(CommentRequest $req){
        $comment = new Comment();
        $comment->name = Auth::user()->name;
        $comment->user_id = Auth::user()->id;
        $comment->text = $req->input('comment');
        $comment->created_at = date('Y-m-d H:i:s');
        $comment->updated_at = NULL;
        $comment->save();
        return redirect("addComment")->with('success', 'Сообщение было добавлено');
    }

    public function allData(){
        return view('comments', ['data' => Comment::all()]);
    }

    public function deleteComment($id){
        DB::delete('delete from comments where id = ?',[$id]);
        return redirect()->back()->with('success', 'Сообщение было удалено!');
    }

    public function dateEditComment($id){
        $comment = new Comment;
        return view('editComment', ['data' => [$comment->find($id)]]);
    }

    public function editComment(CommentRequest $newText, $id){
        if (($oldText = DB::table('comments')->where('id', $id)->value('text')) != ($updateText = $newText->input('comment'))){
            DB::table('comments')
                ->where('id',$id)
                ->update(['text' => $updateText, 'updated_at' => date('Y-m-d H:i:s')]);
            return redirect()->back()->with('editSuccess', 'Сообщение было отредактировано');
        } else {
            return redirect()->back()->with('editError', 'Сообщение не изменилось');
        }
        
    }
}
