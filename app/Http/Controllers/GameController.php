<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    public function create(Request $request){
        try {
        $token = Uuid::uuid4()->toString();
        DB::table('games')->insert(['token' => $token, 'is_active' => true]);
        $words = DB::table('words')->inRandomOrder()->take(25)->first();
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
