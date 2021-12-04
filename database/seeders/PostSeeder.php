<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::select('id')->get();
        $posts = Post::factory(1000)->make()->sortBy('created_at');
        foreach($posts as $post){
            $post->user()->associate($users->random());
            $post->save();
        }
    }
}
