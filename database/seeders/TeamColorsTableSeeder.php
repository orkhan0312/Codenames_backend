<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['Red','Blue'];
        foreach ($colors as $color) {
            DB::table('team_colors')->insert(['color' => $color]);
        }
    }
}
