<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GroupController;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return redirect('posts');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::get('/create', [PostController::class, 'loadGroupsDropdown'])->name('create');
    
    Route::post('/create-post', [PostController::class, 'create'])->name('create-post');
    Route::get('/posts', [PostController::class, 'loadPosts'])->name('posts');

    Route::get('/search', [PostController::class, 'searchPosts'])->name('search');

    Route::get('/user/{id}', [UserController::class, 'load'])->name("user.profile");

    Route::post('/update-avatar', [UserController::class, 'saveAvatar'])->name('update.avatar');

    Route::post('/bio-edit', [ProfileController::class, 'editBio'])->name('editBio');
    Route::post('/bio-delete', [ProfileController::class, 'deleteBio'])->name('deleteBio');

    Route::get('/posts/show/{id}', [PostController::class, 'loadOnePost'])->name('show.post');

    Route::post('/delete-post/{id}', [PostController::class, 'deletePost'])->name('delete-post');

    Route::get('posts/edit/{id}', function ($id) {
        try {
            $post = Post::find($id);
            return view("edit_post", compact('post'));
        } catch (Exception $e) {
            return redirect('posts');
        }
    })->name("edit.post");
    Route::post('posts/edit/{id}', [PostController::class, 'editPost'])->name('edit-post');

    Route::post('/dark-mode-switch', [Controller::class, 'darkMode'])->name('dark-mode-switch');

    Route::post('/create-comment/{id}', [CommentController::class, 'createComment'])->name('create-comment');

    Route::post('/comment/update/{id}', [CommentController::class, 'update'])->name('update-comment');

    Route::post('delete-comment/{id}', [CommentController::class, 'delete'])->name('delete-comment');

    Route::post('/create-reply/{id}', [CommentController::class, 'createComment'])->name('create-reply');

    Route::get('/create_group', function () {
        return view('create_group');
    })->name('createGroup');

    Route::post('/create-group', [GroupController::class, 'create'])->name('create-group');

    Route::get('/groups', [GroupController::class, 'load'])->name('groups');

    Route::middleware('groupmid')->group(function(){
        Route::get('/groups/show/{id}', [GroupController::class, 'loadOneGroup'])->name('show.group');
    
        Route::get('/groups/users/{id}', [GroupController::class, 'loadUsers'])->name('group_users');
    
        Route::get('/groups/add_user/{id}', [GroupController::class, 'addUserToGroup'])->name('addUserToGroup');
    
        Route::get('/groups/delete_user/{id}', [GroupController::class, 'deleteUserFromGroup'])->name('deleteUserFromGroup');
    
        Route::get('/groups/settings/{id}', function ($id) {
            $group = Group::where('id', $id)->first();
            return view('group_settings', compact('group'));
        })->name('group_settings')->middleware('groupmid');
    });

    Route::get('group/deleteGroup/{id}', [GroupController::class, 'delete'])->name('deleteGroup')->middleware('groupmid');

    Route::post('group/transfer/{id}', [GroupController::class, 'transferRights'])->name('transfer');
    Route::post('/groups/search', [GroupController::class, 'searchGroup'])->name('searchGroups')->middleware('searchmid');
    Route::get('/groups/search', function () {
        return redirect('groups');
    });

    // ADMIN PANEL
    Route::get('/admin', [ProfileController::class, 'loadUsers'])->name('admin-panel');
    Route::post('/admin/delete-user/{id}', [ProfileController::class, 'delete'])->name('user-delete');
});
require __DIR__ . '/auth.php';
