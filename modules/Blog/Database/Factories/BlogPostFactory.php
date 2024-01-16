<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Blog\Models\Post;
use Throwable;

class BlogPostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->realText(),
            'image' => $this->createImage(),
            'meta_tag_title' => Str::limit($title, 60, ''),
            'meta_tag_description' => Str::limit($title, 160, ''),
            'published_at' => $this->faker->dateTimeBetween('-6 month', '+3 month'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    private function createImage(): string
    {
        try {
            $image = file_get_contents('https://source.unsplash.com/random/240x240?nature');
        } catch (Throwable $exception) {
            return 'Error fetching image: '.$exception->getMessage();
        }

        $fileName = Str::uuid().'.jpg';

        Storage::disk('public')->put("blog/$fileName", $image);

        return $fileName;
    }
}
