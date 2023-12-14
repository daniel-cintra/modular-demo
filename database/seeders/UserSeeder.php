<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createTestUsers();

        User::factory()
            ->count(12)
            ->create();
    }

    private function createTestUsers(): void
    {
        $users = [
            'Root User' => 'root@user.com',
            'Content Author' => 'author@user.com',
            'Content Director' => 'director@user.com',
        ];

        foreach ($users as $userName => $userEmail) {
            User::factory()->create([
                'name' => $userName,
                'email' => $userEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        }
    }
}
