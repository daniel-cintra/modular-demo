<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AclRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create([
            'name' => 'root',
            'guard_name' => 'user'
        ]);

        Role::create([
            'name' => 'content author',
            'guard_name' => 'user'
        ]);

        Role::create([
            'name' => 'content director',
            'guard_name' => 'user'
        ]);
    }
}
