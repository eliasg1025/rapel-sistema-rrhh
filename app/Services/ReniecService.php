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
        $response = $this->sendRequest('GET', $path);
        $result = json_decode($response['content'])->result;
        return $this->formatData($result);
    }

    private function formatData($data)
    {
        $estado = $data->estado_civil == "" ?? "S";
        $estado_civil_code = DB::table('estado_civiles')->where('name', $estado)->first()->code;
        $departamento_id = DB::table('departamentos')->where('name', $data->departamento)->first()->id;
        $provincia_id = DB::table('provincias')->where([
            'name' => $data->provincia,
            'departamento_id' => $departamento_id
        ])->first()->id;
        $distrito_code = DB::table('distritos')->where([
            'name' => $data->distrito,
            'provincia_id' => $provincia_id,
        ])->first()->code;

        return [
            'rut' => $data->dni,
            'nombre' => $data->nombres,
            'apellido_paterno' => $data->paterno,
            'apellido_materno' => $data->materno,
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
