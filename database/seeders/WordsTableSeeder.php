<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $words = ['Cat', 'Dog'];
        foreach ($words as $word) {
            DB::table('user_roles')->insert(['en' => $word]);
        }
    }
}
