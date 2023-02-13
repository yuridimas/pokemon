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
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'device_name' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'messages' => $validator->errors()
            ]);
        }

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'logged in',
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'logged out, see you later!',
        ]);
    }
}
