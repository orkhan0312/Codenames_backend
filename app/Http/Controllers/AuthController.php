<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $password = DB::table('users')->select('password')->where('email', $request->input('email'))->first();
            if ($password != null) {
                if (Hash::check($request->input('password'), $password->password)) {
                    $token = Uuid::uuid4()->toString();
                    DB::table('users')->where('email', $request->input('email'))->update(['auth_token' => $token, 'login_time' => Carbon::now()]);
                    return parent::asJson(['token' => $token]);
                } else {
                    return parent::asJson(null, 'PASSWORD_MISMATCH', 'Wrong password!');
                }
            } else {
                return parent::asJson(null, 'EMAIL_NOT_FOUND', 'Email not found!');
            }
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getUserByToken(Request $request)
    {
        try {
            $user = DB::table('users')->where('auth_token', $request->header('Auth-Token'))->first();
            return parent::asJson($user);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            DB::table('users')->where('auth_token', $request->header('Auth-Token'))->update(['auth_token' => null, 'logout_time' => Carbon::now()]);
            return parent::asJson(['message' => true]);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function changePassword(Request $request){
        try {
            $user = DB::table('users')->where('auth_token', $request->header('Auth-Token'))->first();
            if($request->input('new') == $request->input('new2')){
                if (Hash::check($request->input('password'), $user->password)) {
                    DB::table('users')->where('auth_token', $request->header('Auth-Token'))->update(['password'=> Hash::make($request->input('new'))]);
                } else {
                    return parent::asJson(null, 'PASSWORD_MISMATCH', 'Wrong password!');
                }
            } else {
                return parent::asJson(null, 'INPUT_MISMATCH', 'Wrong input!');
            }
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
