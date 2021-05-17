<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function get(Request $request)
    {
        try {
            $boards = DB::table('cards')
                ->leftJoin('words', 'cards.word_id', '=', 'words.id')
                ->leftJoin('colors', 'cards.color_id', '=', 'colors.id')
                ->select('cards.*' , 'words.en as word_en', 'colors.color as color')
                ->get();
            return parent::asJson($boards);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $first = rand(0,1)==1;
            DB::table('games')->where('id', $request->input('game_id'))
                ->update(['is_red_first' => $first]);
            if($first == '1') {
                $colors = collect([1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4]);
            } else {
                $colors = collect([1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4]);
            }
            $colors = $colors->shuffle();
            $words = collect(range(1, 25));
            $words = $words->shuffle();
            for ($x = 0; $x < 5; $x++) {
                for ($y = 0; $y < 5; $y++) {
                    $raw = DB::table('cards')->insert(['i' => $x, 'j' => $y, 'color_id' => $colors->pop(),
                        'game_id' => $request->input('game_id'), 'word_id' => $words->pop()]);
                }
            }
            return parent::asJson($first);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('cards')->where('id', $id)
                ->update(['opened_by' => $request->input('opened_by'), 'opened_at' => Carbon::now()]);
            return parent::asJson($id);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
