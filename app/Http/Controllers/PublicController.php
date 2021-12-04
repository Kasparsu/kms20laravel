<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home(){
        $name = "Kaspar";
        $array = ['piim', 'sai', 'leib'];
        return view('home', compact('name', 'array'));
    }

    public function posts(){
        //$posts = Post::select(['title', 'id'])->where('title','LIKE', '%et %')->where('id', '<', 500)->limit(10)->orderBy('title', 'desc')->get();

        $posts = Post::latest()->paginate(16);
        return view('posts', compact('posts'));
    }

    public function post(Post $post){
        return view('post', compact('post'));
    }

    public function tag(Tag $tag){
        $posts = $tag->posts()->latest()->paginate();
        return view('posts', compact('posts'));
    }
}
