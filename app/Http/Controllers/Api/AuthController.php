<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request){
        try{
            // Validated
            $data = Validator::make($request->all(),[
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed'
            ]);

            // Error validator
            if($data->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $data->errors(),
                ], 401);
            }

            // Create user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate user token
            $accessToken  = $user->createToken('authtoken')->plainTextToken;


            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'user' => $user,
                'access_token' => $accessToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    // Login user
    public function login(LoginRequest $request)
    {
        try{
            $request->authenticate();

            $user = $request->user();
            if($user->email_verified_at == null){
                return response()->json([
                    'status' => 'login error',
                    'message' => 'please verify your email'
                ]);
            } else {
                $token = $request->user()->createToken('authtoken');

                return response()->json(
                    [
                        'message'=>'Logged in',
                        'data'=> [
                            'user'=> $request->user(),
                            'token'=> $token->plainTextToken
                        ]
                    ]
                );
            }
        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function logout(Request $request)
    {
        try{
            $request->user()->tokens()->delete();

            return response()->json(
                [
                    'message' => 'Logged out'
                ]
            );
        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
