<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct() 
    {
        // $this->authorizeResource(Post::class, 'post'); // まとめて制限をかける場合  
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = auth()->user();
        $plans = Plan::all();
        return view('post.index', compact('posts', 'user', 'plans'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required|max:1000',
            'image' => 'image|max:1024'
        ]);

        $post = new Post();
        $post->title = $inputs['title'];
        $post->body = $inputs['body'];
        $post->user_id = auth()->user()->id;
        
        if ($request->hasFile('image')) {
            $original = $request->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $request->file('image')->move('storage/images', $name);
            $post->image = $name;
        }
        
        $post->save();

        return redirect()->route('post.create')->with('message', '投稿を作成しました');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required|max:1000',
            'image' => 'image|max:1024'
        ]);

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

        if ($request->hasFile('image')) {
            $original = $request->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $request->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->comments()->delete();
        $post->delete();

        return redirect()->route('post.index')->with('message', '投稿を削除しました。');
    }

    public function mypost()
    {
        $userId = auth()->user()->id;
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('post.mypost', compact('posts'));
    }

    public function mycomment()
    {
        $userId = auth()->user()->id;
        $comments = Comment::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('post.mycomment', compact('comments'));
    }
}
