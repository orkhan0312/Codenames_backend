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
                ->select('cards.*' , 'words.en as word_en', 'words.ru as word_ru', 'colors.color as color')
                ->get();
            return parent::asJson($boards);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getByGameId(Request $request)
    {
        try {
            $boards = DB::table('cards')->where('game_id', $request->header('game_id'))
                ->leftJoin('words', 'cards.word_id', '=', 'words.id')
                ->leftJoin('colors', 'cards.color_id', '=', 'colors.id')
                ->select('cards.*' , 'words.en as word_en', 'words.ru as word_ru',
                    'colors.color as color', 'words.fr as word_fr', 'words.az as word_az')
                ->get();
            return parent::asJson($boards);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $update = DB::table('cards')->where('id', $request->input('card_id'))
                ->update(['opened_by' => $request->input('opened_by'), 'opened_at' => Carbon::now()]);
            return parent::asJson($update);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getByCardId(Request $request)
    {
        try {
            $card = DB::table('cards')->where('cards.id', $request->header('card_id'))
                ->leftJoin('words', 'cards.word_id', '=', 'words.id')
                ->leftJoin('colors', 'cards.color_id', '=', 'colors.id')
                ->select('cards.*' , 'words.en as word_en', 'words.ru as word_ru', 'colors.color as color')
                ->first();
            return parent::asJson($card);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
