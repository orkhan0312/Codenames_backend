<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserTeamController extends Controller
{
    public function get(Request $request)
    {
        try {
            $teams = DB::table('teams_users')
                ->leftJoin('users', 'teams_users.user_id', '=', 'users.id')
                ->leftJoin('teams', 'teams_users.team_id', '=', 'teams.id')
                ->leftJoin('colors', 'teams.color_id', '=', 'colors.id')
                ->leftJoin('user_roles', 'teams_users.user_role_id', '=', 'user_roles.id')
                ->select('teams_users.id', 'teams_users.game_id', 'users.name as user_name', 'teams.name as team_name', 'colors.color as color', 'user_roles.name as role')
                ->get();
            return parent::asJson($teams);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            $team = DB::table('teams_users')->insert(['user_id' => $request->input('user_id'), 'team_id' => $request->input('team_id'),
                'game_id' => $request->input('game_id'),'user_role_id' => $request->input('user_role_id')]);
            return parent::asJson($team);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
