<?php

namespace App\Http\Controllers;

use App\Services\JwtAuthService;
use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $result = Usuario::register($request->all());
        return response()->json([
            'message' => $result['message']
        ], $result['error'] ? 400 : 200);
    }

    public function login(Request $request)
    {
        $result = Usuario::login($request->all());
        return response()->json([
            'message' => $result['message'],
            'token'   => $result['token']
        ], $result['error'] ? 400 : 200);
    }

    public function me(Request $request)
    {
        $token = $request->header('Authorization');
        $result = Usuario::verify($token);
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], $result['error'] ? 400 : 200);
    }

    public function logout(Request $request)
    {
        return response()->json($request);
    }
}
