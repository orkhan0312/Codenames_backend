<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function get(Request $request)
    {
        try {
            $teams = DB::table('teams')
                ->leftJoin('colors', 'teams.color_id', '=', 'colors.id')
                ->select('teams.*', 'colors.color as color')
                ->get();
            return parent::asJson($teams);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $team = DB::table('teams')->insert(['name' => $request->input('name'),
                'game_id' => $request->input('game_id'),'color_id' => $request->input('color_id')]);
            return parent::asJson($team);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
