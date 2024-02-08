<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Group;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function loadUsers()
    {
        $users = User::where('name', '!=', 'admin')->get();
        return view('panel', compact('users'));
    }

    public function delete($id)
    {
        if ($id == 1) {
            return redirect()->route('/posts');
        } else {
            $user = User::find($id);
            Post::where('user_id', $id)->delete();
            Comment::where('user_id', $id)->delete();

            $groups = $user->groups()->wherePivot('is_moderator', true)->get();
            $user->groups()->wherePivot('is_moderator', true)->detach();

            foreach ($groups as $group) {
                if ($group->users()->wherePivot('is_moderator', true)->count() == 0) {
                    $group->delete();
                }
            }
            if ($user->avatar != "1.jpg"){
                File::delete(public_path('storage/' . $user->avatar));
            }
            $user->delete();
            return redirect()->route('admin-panel');
        }
    }
    public function editBio(Request $request){
        if ($request->input('bio_body') == null)
            return redirect()->back();
        else{
            $user = User::find(Auth::user()->id);
            $user->bio_body = $request->input('bio_body');
            $user->save();
            return redirect()->back();
        } 
    }
    public function deleteBio(){
        $user = User::find(Auth::user()->id);
        $user->bio_body = null;
        $user->save();
        return redirect()->back();
    }
}
