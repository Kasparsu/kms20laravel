<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = User::all();
        $posts = Post::all();
        $comments = Comment::all();
        foreach ($posts as $post) {
            foreach ($users->shuffle()->take(rand(0, $users->count())) as $user) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'likable_id' => $post->id,
                    'likable_type' => Post::class
                ]);
            }
        }
        foreach ($comments as $comment) {
            foreach ($users->shuffle()->take(rand(0, $users->count())) as $user) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'likable_id' => $comment->id,
                    'likable_type' => Comment::class
                ]);
            }
        }
    }
}
