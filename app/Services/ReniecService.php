<?php


namespace App\Services;


use App\Traits\ConsumeApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReniecService
{
    use ConsumeApi;

    public $base_url;

    public function __construct()
    {
        $this->base_url = env('RENIEC_API');
    }

    public function getPersona($dni)
    {
        try {
            if (!is_string($dni) || !is_numeric($dni) || strlen($dni) !== 8) {
                throw new \Exception('N° dni no cuenta con formato válido');
            }

            $path = env('RENIEC_API') . "?dni=$dni&refresh=true";
            $response = $this->sendRequest('POST', $path, ['dni' => $dni]);

            $content = json_decode($response['content']);
            if ($content->success) {
                $result = $content->result;

                if ($content->images) {
                    Storage::disk('public')->put(
                        "trabajadores/{$result->num_doc}.png",
                        base64_decode($content->images->foto)
                    );
                }

                return $this->formatData($result);
            }

            throw new \Exception('Persona no encontrada');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function formatData($data)
    {
        try {
            $estado = (
                    $data->estado_civil === '' ||
                    $data->estado_civil === 'null' ||
                    !isset($data->estado_civil) ||
                    is_null($data->estado_civil)
                )
                ? "SOLTERO"
                : explode('(', $data->estado_civil)[0];

            $estado_civil_code = DB::table('estado_civiles')->where('name', 'like', $estado)->first()->code;

            if (is_null($data->ubi_dir_depa_desc) || $data->ubi_dir_depa_desc == "")
            {
                $provincia_id = 67; // CALLAO
            }
            else
            {
                if ($data->ubi_dir_depa_desc == "CUSCO") // CUZCO
                {
                    $departamento_id = 8;
                }
                elseif ($data->ubi_dir_depa_desc == "AMAZONAS") // AMAMZONAS
                {
                    $departamento_id = 1;
                }
                else
                {
                    $departamento_id = DB::table('departamentos')->where('name', $data->ubi_dir_depa_desc)->first()->id;
                }

                $provincia_id = DB::table('provincias')->where([
                    'name'              => $data->ubi_dir_prov_desc,
                    'departamento_id'   => $departamento_id
                ])->first()->id;
            }

            $distrito_code = DB::table('distritos')->where([
                'name'          => $data->ubi_dir_dist_desc,
                'provincia_id'  => $provincia_id,
            ])->first()->code;

            /**
             * Direccion
             */
            $direccion = '';
            if (isset($data->dir_urb) && !is_null($data->dir_urb)) {
                $direccion .= $data->dir_urb;
            }

            if (isset($data->dir_bloque) && !is_null($data->dir_bloque)) {
                $direccion .= ' ' . $data->dir_bloque;
            }

            if (isset($data->dir_dpto_piso) && !is_null($data->dir_dpto_piso)) {
                $direccion = $data->dir_dpto_piso . ' ' . $direccion;
            }

            if (isset($data->dir_etapa) && !is_null($data->dir_etapa)) {
                $direccion .= ' ETAPA ' . $data->dir_etapa;
            }

            if (isset($data->dir_manzana) && !is_null($data->dir_manzana)) {
                $direccion .= ' MZ. ' . $data->dir_manzana;
            }

            if (isset($data->dir_lote) && !is_null($data->dir_lote)) {
                $direccion .= ' LT. ' . $data->dir_lote;
            }

            if (isset($data->dir_nombre) && !is_null($data->dir_nombre) && strlen($data->dir_nombre) <= 25) {
                $direccion = $data->dir_nombre . ' ' . $direccion;
            }

            /* if (trim($direccion) === '') {
                $direccion = isset($data->dir_nombre) && !is_null($data->dir_nombre)
                    ? $data->dir_nombre
                    : 'S/N';
            } */

            $direccion = str_replace("-", "", $direccion);
            $direccion = str_replace("?", "Ñ", $direccion);

            $direccion = $direccion . ' - ' . $data->ubi_dir_dist_desc;

            $apellido_paterno = $data->apellido_paterno;
            if (isset($data->apellido_matrimonio) && !is_null($data->apellido_matrimonio) && $data->cod_sexo !== '1') {
                $apellido_paterno .= ' ' . $data->apellido_matrimonio;
            }

            return [
                'rut'               => $data->num_doc,
                'nombre'            => $data->nombres,
                'apellido_paterno'  => $apellido_paterno,
                'apellido_materno'  => $data->apellido_materno,
                'direccion'         => strtoupper($direccion),
                'fecha_nacimiento'  => $data->fecha_nacimiento,
                'sexo'              => $data->cod_sexo === '1' ? 'M' : 'F',
                'nacionalidad_id'   => 'PE',
                'email'             => $data->email ?? '',
                'telefono'          => $data->telefono ?? '',
                'estado_civil_id'   => $estado_civil_code,
                'distrito_id'       => $distrito_code,
                'tipo_zona_id'      => '',
                'tipo_via_id'       => '',
                'nombre_zona'       => '',
                'nombre_via'        => '',
                'reniec'            => '1'
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
