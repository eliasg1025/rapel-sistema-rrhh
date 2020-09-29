<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Liquidaciones;
use App\Models\Utilidad;
use App\Services\ArchivosAprobacionService;
use App\Services\ArchivosBancoService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class UtilidadesController extends Controller
{
    public function massiveCreate(Request $request)
    {
        $data = $request->get('data');

        $result = Liquidaciones::massiveCreate( $data );

        return response()->json($result);
    }

    public function reprogramarParaPago(Request $request)
    {
        $id = $request->get('id');
        $fecha_pago = $request->get('fecha_pago');

        $finiquito = Utilidad::where('id', $id)->first();

        $finiquito->fecha_pago = $fecha_pago;
        $finiquito->save();

        return response()->json([
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function importar(Request $request)
    {

    }

    public function get(Request $request)
    {
        $estado = $request->estado;
        $fechas = [
            'desde' => Carbon::parse($request->desde),
            'hasta' => $estado == 0 ? Carbon::parse($request->hasta)->lastOfMonth() : Carbon::parse($request->hasta)
        ];
        $empresa_id = $request->empresa_id;

        $resultUtilidades = Utilidad::get($fechas, $estado, $empresa_id);

        return response()->json([ ...$resultUtilidades ]);
    }

    public function getByTrabajador($rut)
    {
        $liquidaciones = Liquidaciones::getByTrabajador($rut);

        return response()->json($liquidaciones);
    }

    public function getPagados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $fecha_pago = $request->query('fecha_pago');
        $rut = $request->query('rut');

        $result = Liquidaciones::getPagados($empresa_id, $fecha_pago, $rut);

        return response()->json($result);
    }

    public function getRechazados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $result = Liquidaciones::getRechazados($empresa_id);

        return response()->json($result);
    }

    public function toggleRechazo($tipo, Request $request)
    {
        $finiquitos = $request->get('finiquitos');

        $result = Liquidaciones::toggleRechazo($tipo, $finiquitos);
        return response()->json($result);
    }

    public function montosPorEstado(Request $request)
    {
        $result = Utilidad::montosPorEstado($request->query('empresa_id'));

        return response()->json($result);
    }

    public function montosPorEstadoPorAnio($empresa_id)
    {
        $result = Utilidad::montosPorEstadoPorAnio($empresa_id);

        return response()->json($result);
    }

    public function cantidadPagosPorDia($empresa_id, Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');
        $result = Utilidad::cantidadPagosPorDia($empresa_id, $desde, $hasta);

        return response()->json($result);
    }
}
