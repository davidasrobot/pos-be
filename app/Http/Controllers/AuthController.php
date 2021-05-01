<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if (User::create([
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ])) {
            $response = [
                "message" => "success",
                "code" => 200
            ];
        } else {
            $response = [
                "message" => "failed",
                "code" => 400
            ];
        }
        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                "Unauthorized",
                "code" => 401
            ], 401);
        }

        if (Hash::check($request->password, $user->password)) {
            $token = $this->generateRandomString();
            $user->update([
                'api_token' => $token
            ]);
            $response = [
                "type" => "Bearer",
                "token" => $token,
                "code" => 200
            ];
        } else {
            $response = [
                "Unauthorized",
                "code" => 401
            ];
        }
        return response()->json($response, $response['code']);
    }

    public function account()
    {
        return response()->json(auth()->user());
    }

    private function generateRandomString($length = 80)
    {
        $char = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = strlen($char);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $char[rand(0, $length - 1)];
        }
        return $string;
    }
}
