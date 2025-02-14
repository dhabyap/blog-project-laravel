<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory(5)->create();
        Post::factory(10)->create()->each(function ($post) {
            $comments = Comment::factory(3)->create(['post_id' => $post->id]);

            $comments->each(function ($comment) {
                Comment::factory()->reply($comment->id)->create();
            });
        });
    }


}
