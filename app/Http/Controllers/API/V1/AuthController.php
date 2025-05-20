<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=> $validator->errors(),
                'message' => 'Validation Error',
                'status' => 422,
            ], 422);
        }
        else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('ABC_123')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'User registered successfully',
                'status' => 201,
            ], 201);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'password'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=> $validator->errors(),
                'message'=> 'Validation Error',
                'status'=> 422,
            ], 422);
        }

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Unauthorized',
                'status'=> 401,
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('ABC_123')->plainTextToken;

        return response()->json([
            'user'=> $user,
            'token'=> $token,
            'message'=> 'U',
        ]), 200;

    }

    public function logout(){

    }
}
