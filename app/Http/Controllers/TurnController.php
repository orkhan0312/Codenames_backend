<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TurnController extends Controller
{
    public function get(Request $request)
    {
        try {
            $turns = DB::table('turns')
                ->select('turns.*')
                ->get();
            return parent::asJson($turns);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getByGameId(Request $request)
    {
        try {
            $turns = DB::table('turns')->where('game_id', $request->header('game_id'))
                ->select('turns.*')
                ->get();
            return parent::asJson($turns);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $update = DB::table('turns')->where('game_id', $request->header('game_id'))
                ->update(['turn' => $request->input('turn')]);
            return parent::asJson($update);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
