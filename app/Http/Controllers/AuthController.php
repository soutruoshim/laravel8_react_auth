<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request){
          try{
              if(Auth::attempt($request->only('email', 'password'))){
                  $user = Auth::user();
                  $token = $user->createToken('app')->accessToken;
                  return response([
                      'message'=>'successfully login',
                      'token'=> $token,
                      'user'=>$user
                  ], 200);
              }
          }catch(Exception $ex){
             return response([
                 'message' => $ex->getMessage()
             ], 400);
          }
          return response(['message'=> 'Invalid Email Or Password'], 401); 
    }

    public function register(RegisterRequest $request){
          try{
              $user = User::create([
                  'name'=>$request->name,
                  'email'=>$request->email,
                  'password'=>Hash::make($request->password) 
              ]);
              $token = $user->createToken('app')->accessToken;
              return response([
                'message'=>'successfully registered',
                'token'=> $token,
                'user'=>$user
            ], 200);

          }catch(Exception $ex){
             return response([
                 'message' => $ex->getMessage()
             ], 400);
          }
    }
}

