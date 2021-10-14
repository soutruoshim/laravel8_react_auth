<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\ResetRequest;
use DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetRequest $request){
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        $emailCheck = DB::table('password_resets')->Where('email',$email)->first();
        $tokenCheck = DB::table('password_resets')->Where('token',$token)->first();
        if(!$emailCheck){
            return response([
                'message' => 'Email not valid'
            ], 401);
        }
        if(!$tokenCheck){
            return response([
                'message' => 'Token not valid'
            ], 401);
        }

        DB::table('users')->where('email', $email)->update(['password'=>$password]);
        DB::table('password_resets')->where('email', $email)->delete();

        return response([
            'message'=>'password changed success'
        ], 200);

    }
}
