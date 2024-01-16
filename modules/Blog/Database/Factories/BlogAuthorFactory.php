<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Blog\Models\Author;
use Throwable;

class BlogAuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'bio' => $this->faker->realTextBetween(),
            'image' => $this->createImage(),
            'github_handle' => $this->faker->userName(),
            'twitter_handle' => $this->faker->userName(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-3 month'),
            'updated_at' => $this->faker->dateTimeBetween('-2 month', 'now'),
        ];
    }

    private function createImage(): string
    {
        try {
            $image = file_get_contents('https://source.unsplash.com/random/240x240?adult');
        } catch (Throwable $exception) {
            return 'Error fetching image: '.$exception->getMessage();
        }

        $fileName = Str::uuid().'.jpg';

        Storage::disk('public')->put("blog/$fileName", $image);

        return $fileName;
    }
}
