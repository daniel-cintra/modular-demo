<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Models\Post;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()
            ->count(12)
            ->create();
    }
}
