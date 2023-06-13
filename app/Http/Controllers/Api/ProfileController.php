<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request){
        try{
            $user = $request->user();

            $data = Validator::make($request->all(),[
                'name' => 'required|string',
                'email' => 'string|unique:users,email'
            ]);

            if($data->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $data->errors(),
                ], 401);
            }

            $user->update([
                'email' => $request->email,
                'name' => $request->name
            ]);
            $user = $user->refresh();

            return response()->json([
                'status' => 'User Updated',
                'user' => $user
            ], 200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
