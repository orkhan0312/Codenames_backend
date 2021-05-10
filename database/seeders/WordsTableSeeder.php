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
        $words = ['cat', 'dog', 'map', 'time', 'year', 'people', 'way',
            'day', 'man', 'thing', 'woman', 'life', 'child', 'world', 'school', 'state',
            'family', 'student', 'group', 'country', 'problem', 'hand', 'part', 'place',
            'case', 'week', 'company', 'system'];
        foreach ($words as $word) {
            DB::table('words')->insert(['en' => $word]);
        }
    }
}
