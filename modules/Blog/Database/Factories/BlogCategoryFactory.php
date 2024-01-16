<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Blog\Models\Category;
use Throwable;

class BlogCategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(4);

        return [
            'name' => $name,
            'description' => $this->faker->realText(),
            'image' => $this->createImage(),
            'is_visible' => $this->faker->boolean(),
            'slug' => Str::slug($name),
            'meta_tag_title' => Str::limit($name, 60, ''),
            'meta_tag_description' => Str::limit($name, 160, ''),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    private function createImage(): string
    {
        try {
            $image = file_get_contents('https://source.unsplash.com/random/320x75?nature');
        } catch (Throwable $exception) {
            return 'Error fetching image: '.$exception->getMessage();
        }

        $fileName = Str::uuid().'.jpg';

        Storage::disk('public')->put("blog/$fileName", $image);

        return $fileName;
    }
}
