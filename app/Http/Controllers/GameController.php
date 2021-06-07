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

    public function create(Request $request)
    {
        try {
            $token = Uuid::uuid4()->toString();
            $first = rand(0,1)==1;

            if($first == '1') {
                $colors = collect([1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4]);
                $turn = 0;
                $red = 9;
                $blue = 8;
            } else {
                $colors = collect([1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4]);
                $turn = 2;
                $red = 8;
                $blue = 9;
            }
            $gameId = DB::table('games')->insertGetId(['token' => $token, 'is_active' => true,
                'lang' => $request->input('lang'), 'timer' => $request->input('timer'),
                'is_red_first' => $first, 'red' => $red, 'blue' => $blue, 'winner' => null]);

            $colors = $colors->shuffle();
            $words = collect(range(1, 680));
            $words = $words->shuffle();
            for ($x = 0; $x < 5; $x++) {
                for ($y = 0; $y < 5; $y++) {
                    $raw = DB::table('cards')->insert(['i' => $x, 'j' => $y, 'color_id' => $colors->pop(),
                        'game_id' => $gameId, 'word_id' => $words->pop()]);
                }
            }

            DB::table('teams')->insert(['name' => 'Red','game_id' => $gameId,'color_id' => 3]);
            DB::table('teams')->insert(['name' => 'Blue','game_id' => $gameId,'color_id' => 4]);

            DB::table('turns')->insert(['game_id' => $gameId, 'turn' => $turn]);

            return parent::asJson($token);
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

    public function update(Request $request)
    {
        try {
            $update = DB::table('games')->where('id', $request->header('game_id'))
                ->update(['red' => $request->input('red'), 'blue' => $request->input('blue'),
                    'is_active' => $request->input('is_active'), 'winner' => $request->input('winner')]);
            return parent::asJson($update);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
