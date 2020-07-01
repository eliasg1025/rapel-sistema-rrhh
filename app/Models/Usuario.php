<?php

namespace App\Models;

use App\Services\JwtAuthService;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /**
     * Eloquent relationships
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }


    /**
     * @param array $data
     * @return array
     *
     */

    public static function register($data=[])
    {
        if (!self::comparePassword($data)) {
            return [
                'error'   => true,
                'message' => 'Las contraseñas son diferentes'
            ];
        }

        try {
            $usuario = new Usuario();
            $usuario->username = $data['username'];
            $usuario->password = md5(sha1($data['password']));
            $usuario->trabajador_id = $data['trabajador_id'];
            $usuario->activo = true;
            $usuario->rol = $data['rol'];
            if ($usuario->save()) {
                return [
                    'message' => 'Usuario con rol ' . $data['rol'] . ' creado correctamente',
                    'error'   => false
                ];
            } else {
                return [
                    'error'   => true,
                    'message' => 'Ocurrió un error inesperado, consulte con el administrador'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error'   => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function login($data)
    {
        $username = $data['username'];
        $password = md5(sha1($data['password']));

        $token = JwtAuthService::signin($username, $password);

        return $token;
    }

    public static function verify($token)
    {
        $verification = JwtAuthService::checkToken($token, true);

        if (!$verification) {
            return [
                'error' => true,
                'message' => 'Error al autenticar el usuario'
            ];
        }

        return [
            'error' => false,
            'message'  => 'Datos obtenidos correctamente',
            'data' => $verification
        ];
    }

    private static function comparePassword($data)
    {
        $password = trim($data['password']);
        $confirm_password = trim($data['confirm_password']);
        return $password == $confirm_password;
    }
}
