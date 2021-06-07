<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function get(Request $request)
    {
        try {
            $teams = DB::table('teams')->where('game_id', $request->header('game_id'))
                ->leftJoin('colors', 'teams.color_id', '=', 'colors.id')
                ->select('teams.*', 'colors.color as color')
                ->get();
            return parent::asJson($teams);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
