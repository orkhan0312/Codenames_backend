<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    public function get(Request $request)
    {
        try {
            $games = DB::table('games')
                ->select('games.*')
                ->get();
            return parent::asJson($games);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function create()
    {
        try {
            $token = Uuid::uuid4()->toString();
            $game = DB::table('games')->insert(['token' => $token, 'is_active' => true]);
            return parent::asJson($game);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getGameByToken(Request $request)
    {
        try {
            $game = DB::table('games')->where('token', $request->header('Auth-Token'))->first();
            return parent::asJson($game);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
