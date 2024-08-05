<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Plan;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = auth()->user();
        $plans = Plan::all();
        return view('guest.index', compact('posts', 'user', 'plans'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('guest.show', compact('post'));
    }
}
