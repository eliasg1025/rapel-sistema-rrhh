<?php

namespace App\Services;

use App\Exports\CargaExcelExport;
use App\Exports\ContratosExport;
use App\Models\CargaExcel;
use App\Models\Contrato;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class FichasExcelService
{
    public function generarExcel($usuario, array $data=[])
    {
        try {
            $exported_data = $this->ordernarDatos($data);
            $exported_data2 = $this->obtenerDatosFicha($data);
            $fecha_actual = Carbon::parse(Carbon::now())->format('Y-m-d');
            $filename = 'cargas-excel/' . $fecha_actual . '/' . time() . '-INGRESOS.xlsx';
            $generated = Excel::store(new CargaExcelExport($exported_data, $exported_data2), $filename, 'public');

            if ($generated) {
                $carga_excel = new CargaExcel();
                $carga_excel->fecha_hora = now()->toDateTimeString();
                $carga_excel->link = $filename;
                $carga_excel->usuario_id = $usuario['id'];
                if ($carga_excel->save()) {
                    return true;
                }
                return false;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ordernarDatos(array $data=[])
    {
        $cabeceras = [
            'DNI',
            'TIPODOCIDEN',
            'APELLIDOP',
            'APELLIDOM',
            'NOMBRES',
            'FECHA NAC',
            'ESTADO',
            'SEXO',
            'NACIONALIDAD',
            'DIRECCION',
            'COMUNA',
            'ZONA LABORES',
            'TIPO DE ZONA',
            'NOMBRE ZONA',
            'TIPO DE VIA',
            'NOMBRE VIA',
            'MANZANA',
            'LOTE',
            'NUMERO',
            'INTERIOR',
            'NIVEL EDUCACIONAL',
            'TRONCAL',
            'RUTA',
            'TELEFONO',
            'TIPO DE TRABAJADOR',
            'T. TRABAJADOR',
            'A.F.P.',
            'ISAPRE',
            'MONEDA',
            'Comisión',
            'CUSSP',
            'MIXTA',
            'F. AFILIACION',
            'REGIMEN',
            'C. COSTO/ PREDIO',
            'SC.COSTO/CUARTEL',
            'AGRUPACION',
            'ACTIVIDAD',
            'LABOR',
            'OFICIO',
            'SUELDO DIARIO',
            'MONEDASUELDO',
            'Fecha de Inicio',
            'Fecha de Término',
            'TIPO DE CONTRATO'
        ];

        $exported_data = [
            $cabeceras,
        ];
        foreach ($data as $d) {
            $contrato_id = $d['contrato_id'];
            $data_contrato = Contrato::_showFila($contrato_id);
            array_push($exported_data, $data_contrato);
        }

        return $exported_data;
    }

    public function obtenerDatosFicha(array $data=[])
    {
        $cabeceras = [
            '',
            'RutTrabajador',
            'CodigoTrabajador',
            'Ap.Paterno',
            'Ap. Materno',
            'Nombre',
            'FechaNacimiento',
            'F. Nac. Letras',
            'Edad',
            'Sexo',
            'Direccion',
            'DISTRITO',
            'PROVINCIA',
            'DEPARTAMENTO',
            'EstadoCivil',
            'F. Ingreso',
            'F. Ingreso Letras',
            'F. Término Letras',
            'Activo',
            'Alerta',
            'GRUPO',
            'CODIGO',
            'TRONCAL',
            'RUTA',
            'Mes de Desc. Antec. Polic.',
            'Mes Desc. Letras',
            'FUNDO',
            'ESTADO CIVIL',
            'TELEFONO',
            'EMAIL',
            'EMPRESA'
        ];

        $exported_data = [
            $cabeceras,
        ];

        foreach ($data as $d) {
            $contrato_id = $d['contrato_id'];
            $data_contrato = Contrato::_showFichaTrabajador($contrato_id);
            array_push($exported_data, $data_contrato);
        }

        return $exported_data;
    }
}
