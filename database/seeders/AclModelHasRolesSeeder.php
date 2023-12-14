<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AclModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->truncate();

        //root
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'user',
            'model_id' => 1
        ]);

        //content author
        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'user',
            'model_id' => 2
        ]);

        //content director
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'user',
            'model_id' => 3
        ]);
    }
}
