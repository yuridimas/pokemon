<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'device_name' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'messages' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if ($user) {

            return response()->json([
                'status' => true,
                'message' => 'logged in',
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ], Response::HTTP_OK);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'your email is not registered',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'logged out, see you later!',
        ], Response::HTTP_OK);
    }
}
