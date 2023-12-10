<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Response;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:128|unique:users',
            'password'  => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $emailParts = explode('@', $request->email);

        // Get the text before "@" (username or local part)
        $username = $emailParts[0];

        $user = User::create([
            'email'     => $request->email,
            'name'      => Str::ucfirst($username),
            'password'  => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "ok"    => true,
            "data"  => [
                "user"          => $user,
                "access_token"  => $token,
                "refresh_token" => "8eebef3c-03e0-4ead-b78e-27bac3fc43c3"
            ]
        ]);
    }

    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return Response::unauthorized();
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "ok"    => true,
            "data"  => [
                "user"          => $user,
                "access_token"  => $token,
                "refresh_token" => "8eebef3c-03e0-4ead-b78e-27bac3fc43c3"
            ]
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
