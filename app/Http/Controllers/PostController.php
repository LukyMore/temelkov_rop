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
    public function loadGroupsDropdown()
    {
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
        $posts = Post::all();
        $groups = Auth::user()->groups;
        $sort_by = $request->get('sort_by');
        $group_select = $request->get('group_select');
        $query = Post::query();
        if (!empty($group_select)) {
            $query->where('group_id', $group_select);
        } else {
            $query->where('group_id', 0);
        }
    
        // Apply sorting based on the selected option or default to descending order
        switch ($sort_by) {
            default:
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }
    
        $posts = $query->get();
        if (empty($posts)) {
            DB::table('posts')->truncate();
        }
        return view('posts', compact('posts', 'groups'));
    }

    public function searchPosts(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            $posts = Post::where('id', 0)->get();
            return redirect('posts');
        } else {
            $posts = Post::where('title', 'LIKE', '%' . $query . '%')->orWhere('body', 'LIKE', '%' . $query . '%')->get();
            foreach ($posts as $post) {
                $post->title = str_replace($query, '<mark>' . $query . '</mark>', $post->title);
            }
        }
        return view('search', compact('posts', 'query'));
    }

    public function loadOnePost(Request $request, $id)
    {
        $post = Post::find($id);
        $comments = Comment::where('post_id', '=', $id)->whereNull('parent_id')->get();
        return view('show_post', compact('post', 'comments'));
    }

    public function deletePost($id)
    {
        Post::where('id', $id)->delete();
        Comment::where('post_id', $id)->delete();
        //DB::table('posts')->where('id', $id)->delete();

        if (Post::count() == 0) {
            Post::query()->truncate();
        }
        return back();
    }

    public function editPost(Request $request, $id)
    {
        $post = Post::find($id);
        if ($post->user_id != Auth::user()->id){
            return redirect('posts')->with('error', "Nemůžeš upravit ostatní příspěvky");
        }
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ], [
                'title.required' => 'Zadejte název článku.',
                'body.required' => 'Zadejte obsah článku.'
            ]);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->update();
        return redirect('posts');
    }
}