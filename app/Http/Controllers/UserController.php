<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get()
    {
        try {
            $users = DB::table('users')
                ->select('users.*')
                ->get();
            return parent::asJson($users);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            $request->merge(['password' => Hash::make($request->input('password')), 'created_at' => Carbon::now()]);
            $id = DB::table('users')->insertGetId($request->all());
            return parent::asJson($id);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge(['password' => Hash::make($request->input('password'))]);
            DB::table('users')->where('id', $id)->where('auth_token',
                $request->header('Auth-Token'))->update(['name' => $request->input('name'),
                'surname' => $request->input('surname'), 'email' => $request->input('email'),
                'nickname' => $request->input('nickname'), 'password' => $request->input('password'),
                'updated_by' => $request->input('updated_by'), 'updated_at' => Carbon::now()]);
            return parent::asJson($id);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::table('users')->where('id', $id)->where('auth_token', $request->header('Auth-Token'))
                ->update(['deleted_by' => $request->input('deleted_by'), 'deleted_at' => Carbon::now()]);
            return parent::asJson($id);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
