<?php

namespace App\Services;

use App\Models\Trabajador;
use Firebase\JWT\JWT;
use App\Models\Usuario;

class JwtAuthService
{
    public static function getToken(Usuario $usuario)
    {
        try {
            $token = [
                'sub' => $usuario->id,
                'username' => $usuario->username,
                'rol' => $usuario->rol,
                'trabajador' => $usuario->trabajador,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            ];

            $jwt = JWT::encode($token, env('JWT_KEY') || 'TEST_TOKEN_KEY', 'HS256');

            return $jwt;
        } catch(\Exception $e) {
            return null;
        }
    }

    public static function signin(string $username, string $password)
    {
        try {
            $usuario = Usuario::where([
                'username' => $username,
            ])->first();

            if (!$usuario) {
                return [
                    'error'   => true,
                    'message' => 'El usuario no existe',
                    'token' => null,
                ];
            }

            if ($usuario->password !== $password) {
                return [
                    'error' => true,
                    'message' => 'Contraseña incorrecta',
                    'token' => null,
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

            $jwt = JWT::encode($token, env('JWT_KEY') || 'TEST_TOKEN_KEY', 'HS256');

            return [
                'error'   => false,
                'message' => 'Usuario logeado correctamente',
                'token'   => $jwt
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'token' => null,
                'message' => 'Error al iniciar sesión'
            ];
        }
    }

    public static function checkToken($jwt, $get_identity=false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, env('JWT_KEY') || 'TEST_TOKEN_KEY', ['HS256']);
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
