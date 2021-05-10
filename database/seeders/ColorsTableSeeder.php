<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['White','Black','Red','Blue'];
        foreach ($colors as $color) {
            DB::table('colors')->insert(['color' => $color]);
        }
    }
}
