<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Spymaster','Ordinary'];
        foreach ($roles as $role) {
            DB::table('user_roles')->insert(['name' => $role]);
        }
    }
}
