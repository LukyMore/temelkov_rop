<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class CommentController extends Controller
{
    public function createComment(Request $request){
        $request->validate([
            'body' => 'required',
        ], [
            'body.required' => 'Nemůžete napsat prázdný komentář.'
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->input('post_id');
        $comment->save();
        return back();
    }
}
