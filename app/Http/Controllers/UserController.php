<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function load($id){
        setlocale(LC_TIME, 'cs_CZ.utf8');
        $user =  User::find($id);
        $posts = Post::where("user_id", $id)->get();
        return view("profile.show", compact("user", "posts"));
    }

    public function saveAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|file|image|max:2048'
        ]);
        
        $user = Auth::user();
        
        $fileName = time() . '-' . uniqid() . '.' . $request->file('avatar')->extension();
        
        File::delete(public_path('storage/'.$user->avatar));
        $avatarUploaded = $request->file('avatar');
        $avatarPath = public_path('/storage/');
        $avatarUploaded->move($avatarPath, $fileName);
        $user = Auth::user();
        $user->avatar = $fileName;
        $user->save();
        return redirect()->route('user.profile', ['id' => Auth::user()->id]);
    }
}
