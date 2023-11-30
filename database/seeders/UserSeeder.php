<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createTestUser();

        User::factory()
            ->count(12)
            ->create();
    }

    private function createTestUser(): void
    {
        $testUser = User::factory()->create([
            'name' => 'Example User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        Role::create(['name' => 'root']);

        $testUser->assignRole('root');
    }
}
