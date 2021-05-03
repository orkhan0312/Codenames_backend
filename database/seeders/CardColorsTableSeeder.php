<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['Red','Blue','White','Black'];
        foreach ($colors as $color) {
            DB::table('card_colors')->insert(['color' => $color]);
        }
    }
}
