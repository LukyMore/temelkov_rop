<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function loadGroupsDropdown(){
        $groups = Auth::user()->groups;
        return view('create_post', compact('groups'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'group_id' => 'required|not_in:choose'
        ], [
            'title.required' => 'Zadejte název článku.',
            'body.required' => 'Zadejte obsah článku.',
            'group_id.required' => 'Vyberte skupinu.'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id();
        $post->group_id = $request->group_id;
        $post->save();
        return redirect('posts');
    }
    public function loadPosts(Request $request)
    {
        $posts = Post::where('group_id','0')->get();
        $sort_by = $request->get('sort_by');
        switch ($sort_by){
            default:
                $posts = Post::where('group_id','0')->orderBy('created_at', 'desc')->get();
                break;
            case 'oldest':
                $posts = Post::where('group_id','0')->orderBy('created_at', 'asc')->get();
                break;
        }
        if (empty($posts))
        {
            DB::table('posts')->truncate();
        }
        return view('posts', compact('posts'));
    }

    public function searchPosts(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            $posts = Post::all();
            return redirect('posts');
        } else {
            $posts = Post::where('title', 'LIKE', '%' . $query . '%')->orWhere('body', 'LIKE', '%' . $query . '%')->get();
            foreach ($posts as $post) {
                $post->title = str_replace($query, '<mark>'.$query.'</mark>', $post->title);
            }
        }
        return view('search', compact('posts', 'query'));
    }

    public function loadOnePost(Request $request, $id)
    {
        $post = Post::find($id);
        $comments = Comment::where('post_id', '=', $id)->get();
        return view('show_post', compact('post', 'comments'));
    }
    
    public function deletePost($id){
        DB::table('posts')->where('id', $id)->delete();

        if (Post::count() == 0){
            Post::query()->truncate();
        }
        
        return back();
    }

    public function editPost(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ], [
            'title.required' => 'Zadejte název článku.',
            'body.required' => 'Zadejte obsah článku.'
        ]);
        $post = Post::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->update();
        return redirect('posts');
    }
}
