<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Blog\Models\Post;

use function Laravel\Prompts\info;
use function Laravel\Prompts\progress;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('public/blog');

        Schema::disableForeignKeyConstraints();

        info('Creating users...');
        $this->call(UserSeeder::class);
        info('Users created.');

        info('Creating blog posts...');
        $this->seedWithProgress(
            label: 'Post creation status',
            steps: 6,
            callback: fn () => Post::factory()->create(),
        );
        info('Blog posts created.');

        Schema::enableForeignKeyConstraints();
    }

    private function seedWithProgress(string $label, int $steps, callable $callback): void
    {
        progress(
            label: $label,
            steps: $steps,
            callback: $callback,
        );
    }
}
