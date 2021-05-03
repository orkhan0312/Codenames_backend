<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerRolesTableSeeder extends Seeder
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
            DB::table('player_roles')->insert(['name' => $role]);
        }
    }
}
