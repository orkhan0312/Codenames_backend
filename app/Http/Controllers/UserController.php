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
            $students = DB::table('students')
                ->select('students.*')
                ->get();
            return parent::asJson($students);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            $request->merge(['password' => Hash::make($request->input('password')), 'created_at' => Carbon::now()]);
            $id = DB::table('students')->insertGetId($request->all());
            return parent::asJson($id);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
