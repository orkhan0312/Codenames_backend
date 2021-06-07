<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClueController extends Controller
{
    public function get(Request $request)
    {
        try {
            $clues = DB::table('clues')
                ->leftJoin('teams', 'clues.team_id', '=', 'teams.id')
                ->leftJoin('colors', 'teams.color_id', '=', 'colors.id')
                ->select('clues.*' , 'teams.name as team_name', 'colors.color as color')
                ->get();
            return parent::asJson($clues);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            $clue = DB::table('clues')->insert(['clue' => $request->input('clue'), 'word_count' => $request->input('word_count'),
                'game_id' => $request->input('game_id'), 'team_id' => $request->input('team_id'), 'user_id' => $request->input('user_id')]);
            return parent::asJson($clue);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getByGameId(Request $request)
    {
        try {
            $clues = DB::table('clues')->where('clues.game_id', $request->header('game_id'))
                ->leftJoin('users', 'clues.user_id', '=', 'users.id')
                ->leftJoin('teams', 'clues.team_id', '=', 'teams.id')
                ->leftJoin('colors', 'teams.color_id', '=', 'colors.id')
                ->select('clues.*' , 'users.nickname as nickname', 'teams.name as team_name', 'colors.color as color')
                ->get();
            return parent::asJson($clues);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
