<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function login(Request $request)
  {

    $validator=\Validator::make($request->all(),[
      'email' =>'required',
      'password' => 'required'
    ]);

    if($validator->fails()){
      return response(['data'=>$validator->errors()->all(),'status'=>400],400);
    }

    if(!auth()->validate(['email'=>$request->input('email'),'password'=>$request->input('password')])){
      return response(['data'=>'Un authorized']);
    };

    //-----get api_token for users authenticate--------

    return response(['data'=>\App\User::whereEmail($request->input('email'))->first()->api_token,'status'=>200]);
  }




}