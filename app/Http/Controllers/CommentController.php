<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class CommentController extends Controller
{
    public function createComment(Request $request, $id){
        $request->validate([
            'body' => 'required',
        ], [
            'body.required' => 'Nemůžete napsat prázdný komentář.'
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        if ($request->input('comment_id') != null){
            $comment->parent_id = $request->input('comment_id');
        }
        $comment->save();
        return back();
    }
    public function delete($id){
        $comment = Comment::find($id);
        if ($comment->replies->count() > 0){
            $comment->replies()->delete();
        }
        $comment->delete();
        return redirect()->back();
    }
    public function update(Request $request, $id){
        $comment = Comment::find($id);
        $comment->body = $request->updatedText;
        $comment->update();
        return redirect()->back();
    }
}
