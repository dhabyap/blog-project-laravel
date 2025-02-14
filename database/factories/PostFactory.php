<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(10),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'image' => 'assets/images/blog/blog-post-thumb-' . rand(1, 3) . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


}
