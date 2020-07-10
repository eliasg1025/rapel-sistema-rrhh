<?php

namespace App\Models;

use App\Services\JwtAuthService;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $hidden = ['password'];

    /**
     * Eloquent relationships
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    /**
     * Static methods
     */
    public static function _get(bool $activo)
    {
        $usuarios = Usuario::where('activo', $activo)->get();
        return $usuarios->map(function($usuario) {
            $usuario->trabajador = $usuario->trabajador->select('nombre', 'apellido_paterno', 'apellido_materno');
            return $usuario;
        });
    }

    public static function _update(array $data=[], $usuario)
    {
        try {
            $usuario->username = $data['username'];
            if ($data['password'] && $data['confirm_password']) {
                if (!self::comparePassword($data)) {
                    return [
                        'error'   => true,
                        'message' => 'Las contraseñas son diferentes'
                    ];
                }
                $usuario->password = md5(sha1($data['password']));
            }
            $usuario->rol = $data['rol'];
            if ($usuario->save()) {
                return [
                    'message' => 'Usuario ' . $data['username'] . ' actualizado correctamente',
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
            $usuario->trabajador_id = $data['trabajador_id'] ?? Trabajador::findOrCreate($data['trabajador']);
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

    public static function verifyWeb(array $data)
    {
        try {
            $username = trim($data['username']);
            $password = trim(strtolower($data['password']));

            $usuario = Usuario::whereUsername($username)->first();
            if ($usuario) {
                if ($usuario->password == md5(sha1($password))) {
                    $usuario->trabajador = Trabajador::where('id', $usuario->trabajador_id)
                        ->select('id', 'rut', 'apellido_paterno', 'apellido_materno', 'nombre')
                        ->first();
                    return $usuario;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    private static function comparePassword($data)
    {
        $password = trim($data['password']);
        $confirm_password = trim($data['confirm_password']);
        return $password == $confirm_password;
    }
}
