<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Zadejte název skupiny.',
        ]);

        $group = new Group();
        $group->name = $request->name;
        $user = User::find(Auth::user()->id);
        $group->mod_name = $user->name;
        $group->save();
        $user->groups()->attach($group, ['is_moderator' => 1]);
        return redirect('posts');
    }

    public function load()
    {
        $groups = Group::all();
        return view('groups', compact('groups'));
    }

    public function loadOneGroup($id)
    {
        $group = Group::find($id);
        $posts = Post::where('group_id', '=', $id)->get();
        return view('show_group', compact('group', 'posts'));
    }

    public function loadUsers($id)
    {
        $group = Group::find($id);
        $posts = Post::where('group_id', $id)->get();
        return view('group_users', compact('group'));
    }

    public function addUserToGroup($id)
    {
        $user = User::find(Auth::user()->id);
        $group = Group::where('id', $id)->first();
        $user->groups()->attach($group, ['is_moderator' => 0]);
        return redirect('groups');
    }

    public function deleteUserFromGroup($id)
    {
        if (Auth::user()->groups->where('id', $id)->first() && Auth::user()->groups->where('id', $id)->first()->pivot->is_moderator) {
            return back();
        } else {
            $user = User::find(Auth::user()->id);
            $group = Group::where('id', $id)->first();
            $user->groups()->detach($group);
            return redirect('groups');
        }
    }

    public function delete($id)
    {
        $group = Group::where('id', $id)->first();
        Post::where('group_id', $id)->delete();
        $group->users()->detach();
        $group->delete();
        return redirect('groups');
    }

    public function transferRights(Request $request, $id)
    {
        $newModerator = $request->new_moderator;
        $group = Group::find($id);
        $currentModerator = $group->users()->wherePivot('is_moderator', true)->first();
        $currentModerator->groups()->updateExistingPivot($id, ['is_moderator' => false]);
        $newMod = User::find($newModerator);
        $newMod->groups()->updateExistingPivot($id, ['is_moderator' => true]);
        return redirect()->back();
    }
    
    public function searchGroup(Request $request){
        $query = $request->post('query');

        if (empty($query)) {
            $groups = Group::all();
            return redirect('groups');
        } else {
            $groups = Group::where('name', 'like', "%{$query}%")->get();
        }
        return view('groups', compact('groups', 'query'));
    }
}
