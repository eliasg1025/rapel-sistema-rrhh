<?php


namespace App\Services;


use App\Models\Departamento;
use App\Models\EstadoCivil;
use App\Models\Provincia;
use App\Traits\ConsumeApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReniecService
{
    use ConsumeApi;

    public $base_url;

    public function __construct()
    {
        $this->base_url = env('RENIEC_API');
    }

    public function getPersona($dni, $imagenes=1)
    {
        $path = $dni . '/' . $imagenes;
        $response = $this->sendRequest('POST', $path);

        $content = json_decode($response['content']);
        if ($content->success) {
            $result = $content->result;
            return $this->formatData($result);
        }

        return null;
    }

    private function formatData($data)
    {
        $estado = $data->estado_civil == "" ? "SOLTERO" : $data->estado_civil;
        $estado_civil_code = DB::table('estado_civiles')->where('name', $estado)->first()->code;

        if ($data->departamento == "")
        {
            $provincia_id = 67; // CALLAO
        }
        else
        {
            if ($data->departamento == "CUSCO") // CUZCO
            {
                $departamento_id = 8;
            }
            elseif ($data->departamento == "AMAZONAS") // AMAMZONAS
            {
                $departamento_id = 1;
            }
            else
            {
                $departamento_id = DB::table('departamentos')->where('name', $data->departamento)->first()->id;
            }

            $provincia_id = DB::table('provincias')->where([
                'name' => $data->provincia,
                'departamento_id' => $departamento_id
            ])->first()->id;
        }

        $distrito_code = DB::table('distritos')->where([
            'name' => $data->distrito,
            'provincia_id' => $provincia_id,
        ])->first()->code;

        return [
            'rut' => $data->dni,
            'nombre' => str_replace("Ãâ", "Ñ", $data->nombres),
            'apellido_paterno' => str_replace("Ãâ", "Ñ", $data->apellido_paterno),
            'apellido_materno' => str_replace("Ãâ", "Ñ", $data->apellido_materno),
            'direccion' => strtoupper($data->direccion) . " - " . $data->distrito,
            'fecha_nacimiento' => Carbon::createFromFormat('d/m/Y', $data->fecha_nacimiento)->format('Y-m-d'),
            'sexo' => $data->sexo === '1' ? 'M' : 'F',
            'nacionalidad_id' => 'PE',
            'email' => $data->email ?? "",
            'telefono' => $data->telefono ?? "",
            'estado_civil_id' => $estado_civil_code,
            'distrito_id' => $distrito_code,
            'tipo_zona_id' => "",
            'tipo_via_id' => "",
            'nombre_zona' => "",
            'nombre_via' => "",
            'reniec' => '1'
        ];
    }
}
