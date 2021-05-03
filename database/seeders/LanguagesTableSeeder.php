<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = ['English','French','Russian','Azeri'];
        foreach ($languages as $language) {
            DB::table('languages')->insert(['type' => $language]);
        }
    }
}
