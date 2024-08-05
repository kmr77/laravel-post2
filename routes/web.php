<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ゲストユーザー用の投稿一覧と詳細
Route::get('/', [PostController::class, 'index'])->name('top');
// Route::get('/', [TopController::class, 'index'])->name('guest.top');
// Route::get('guest/{id}', [TopController::class, 'show'])->name('guest.show');

//welcomeページを開く記述（必要に応じて残すか削除してください）
// Route::get('/', function () {
//     return view('welcome');
// })->name('top');

Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

// ログイン後の通常のユーザー画面
Route::middleware(['verified'])->group(function(){
    Route::get('post/mypost', [PostController::class, 'mypost'])->name('post.mypost');
    Route::get('post/mycomment', [PostController::class, 'mycomment'])->name('post.mycomment');
    Route::resource('post', PostController::class)->except(['index', 'show']);
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show/{user}', [ProfileController::class, 'show'])->name('profile.show');
});

// 投稿の一覧と詳細表示（未ログインユーザーもアクセス可能）
Route::get('post', [PostController::class, 'index'])->name('post.index');
Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
    
    // 管理者用画面
    Route::middleware(['auth', 'can:admin'])->group(function () {
        Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/reindex', [ProfileController::class, 'reindex'])->name('profile.reindex');
        Route::get('/profile/adedit/{user}', [ProfileController::class, 'adedit'])->name('profile.adedit');
        Route::patch('/profile/adupdate/{user}', [ProfileController::class, 'adupdate'])->name('profile.adupdate');
        Route::patch('/profile/planupdate/{user}', [ProfileController::class, 'planupdate'])->name('profile.planupdate');
        Route::delete('profile/{user}', [ProfileController::class, 'addestroy'])->name('profile.addestroy');
        Route::patch('profile/{user}', [ProfileController::class, 'isdelete'])->name('profile.isdelete');
        Route::patch('profile/restore/{trashed_user}', [ProfileController::class, 'restore'])->name('profile.restore');
        Route::patch('roles/{user}/attach', [RoleController::class, 'attach'])->name('role.attach');
        Route::patch('roles/{user}/detach', [RoleController::class, 'detach'])->name('role.detach');
        Route::patch('plans/{user}/attach', [PlanController::class, 'attach'])->name('plan.attach');
        Route::patch('plans/{user}/detach', [PlanController::class, 'detach'])->name('plan.detach');
    });

require __DIR__.'/auth.php';
