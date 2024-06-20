<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Blog\Models\Category;

class BlogCategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(4);

        return [
            'name' => $name,
            'description' => $this->faker->realText(),
            'image' => $this->faker->imageUrl(),
            'is_visible' => $this->faker->boolean(),
            'slug' => Str::slug($name),
            'meta_tag_title' => Str::limit($name, 60, ''),
            'meta_tag_description' => Str::limit($name, 160, ''),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
