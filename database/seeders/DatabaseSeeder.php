<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Acl\Database\Seeders\AclModelHasRolesSeeder;
use Modules\Acl\Database\Seeders\AclPermissionSeeder;
use Modules\Acl\Database\Seeders\AclRoleHasPermissionsSeeder;
use Modules\Acl\Database\Seeders\AclRoleSeeder;
use Modules\Blog\Models\Author;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\User\Database\Seeders\UserSeeder;

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

        info('Creating ACL roles...');
        $this->call(AclRoleSeeder::class);
        info('ACL roles created.');

        info('Creating ACL permissions...');
        $this->call(AclPermissionSeeder::class);
        info('ACL permissions created.');

        info('Assigning ACL permissions to roles...');
        $this->call(AclRoleHasPermissionsSeeder::class);
        info('ACL permissions assigned to roles.');

        info('Assigning ACL roles to users...');
        $this->call(AclModelHasRolesSeeder::class);
        info('ACL roles assigned to users.');

        info('Creating blog categories...');
        $this->seedWithProgress(
            label: 'Categories creation status',
            steps: 12,
            callback: fn () => Category::factory()->create(),
        );
        info('Blog categories created.');

        info('Creating blog authors...');
        $this->seedWithProgress(
            label: 'Authors creation status',
            steps: 12,
            callback: fn () => Author::factory()->create(),
        );
        info('Blog authors created.');

        info('Creating blog posts...');
        $this->seedWithProgress(
            label: 'Posts creation status',
            steps: 24,
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
