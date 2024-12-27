<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // index
    public function index($email)
    {
        $user = User::where('email', $email)->first();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    // get all user
    public function getAllUser()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // check email
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email is already registered',
                'valid' => false,
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Email not registered',
                'valid' => true,
            ], 404);
        }
    }

    // login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 200);
    }

    // logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Token deleted',
        ], 200);
    }

    public function getImage($filename)
    {
        $path = public_path("storage/$filename");

        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
