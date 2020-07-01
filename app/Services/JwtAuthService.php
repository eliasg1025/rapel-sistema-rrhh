<?php

namespace App\Services;

use App\Models\Trabajador;
use Firebase\JWT\JWT;
use App\Models\Usuario;

class JwtAuthService
{
    public static function signin(string $username, string $password)
    {
        $usuario = Usuario::where([
            'username' => $username,
            'password' => $password
        ])->first();

        if (!$usuario) {
            return [
                'error'   => true,
                'message' => 'El usuario no existe'
            ];
        }

        $trabajador = Trabajador::where('id', $usuario->trabajador_id)
                ->select('id', 'rut', 'apellido_paterno', 'apellido_materno', 'nombre')
                ->first();

        $token = [
            'sub' => $usuario->id,
            'username' => $usuario->username,
            'rol' => $usuario->rol,
            'trabajador' => $trabajador,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60)
        ];

        $jwt = JWT::encode($token, env('JWT_KEY'), 'HS256');

        return [
            'error'   => false,
            'message' => 'Usuario logeado correctamente',
            'token'   => $jwt
        ];
    }

    public static function checkToken($jwt, $get_identity=false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, env('JWT_KEY'), ['HS256']);
        } catch (\Exception $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        }

        if ($get_identity) {
            return $decoded;
        }

        return $auth;
    }
}
