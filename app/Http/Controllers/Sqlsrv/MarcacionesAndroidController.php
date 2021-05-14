<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcacionesAndroidController extends Controller
{
    public function get(Request $request)
    {
        $fecha = $request->get('fecha');
        $empresaId = $request->get('empresa_id');
        $rut = $request->get('rut');

        if (!$fecha) {
            return response()->json([
                'message' => 'Falta asignar una fecha',
            ], 400);
        }

        $result = DB::connection('sqlsrv2')->select("SPC_Marcacion_Android_Trab @IdEmpresa = $empresaId, @Desde = '$fecha', @Hasta = '$fecha', @RutTrabajador = $rut");

        return response()->json([
            'message' => 'Resultados obtenidos correctamente',
            'data' => $result
        ]);
    }

    /* public function getRegistro(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $empresaId = $request->get('empresa_id');

        $periodo = CarbonPeriod::create($desde, $hasta);

        $regimenes = [
            'Administrativos',
            'Empleados Agrarios'
        ];

        $oficiosExcluidos = [
            'CHOFER',
            'CASETERO DE RIEGO'
        ];

        $result = [];
        foreach ($periodo as $fecha) {
            $fecha = $fecha->format('d/m/Y');
            $data = DB::connection('sqlsrv')->select("SPC_LECTURAS_SMART @EMPRESA=$empresaId, @Fecha='$fecha',@ReCalcular=1");
            $result = [ ...$result, ...$data ];
        }

        $result = array_values(array_filter($result, function($item) use ($regimenes, $oficiosExcluidos) {
            return in_array($item->{'Tipo Regimen'}, $regimenes)
                //&& strlen($item->{'Estacion Entrada'}) !== 7;
                && !in_array($item->{'CARGO'}, $oficiosExcluidos);
        }));

        return response()->json([
            'message'   => 'Registros obtenidos correctamente',
            'data'      => $result
        ]);
    } */

    public function getRegistro(Request $request)
    {
        $empresaId = $request->get('empresa_id');

        $result = DB::connection('sqlsrv2')->select("
        SELECT DISTINCT
        [DNI]=Replicate('0', 8 - Len(T.RutTrabajador)) + ltrim(str(T.RutTrabajador))
        ,[APELLIDOS_NOMBRES]=T.ApellidoPaterno + ' ' + T.ApellidoMaterno + ' ' + T.Nombre
        ,[CARGO]=O.Descripcion
        ,[CENTRO_COSTO]=Z.NOM_CENTROCOSTO
        ,[Tipo Regimen]= TR.descripcion
        ,[Terminal Ingr] = CONVERT(VARCHAR(24),L.HorarioEntrada,108)
        ,[Terminal Sal] = CONVERT(VARCHAR(24),L.HorarioSalida,108)
        ,L.FECHA
        ,[Estacion Entrada] = E_INI.NOMBRE_ESTACION
        ,[Hora Ingreso] = LEFT(L.[HORAINICIO],8)
        ,[Estacion Salida] = E_FIN.NOMBRE_ESTACION
        ,[Hora Salida] = LEFT(L.HORAFINAL,8)
        --,[H_Trabajo] = ROUND(L.[H_Trabajo],2)
        --,[Horas_Extra] = ROUND(L.[Horas_Extra],2)
        ,[Tardanza] = ROUND(L.Tardanza,2)
        ,T.IdEmpresa
        ,Empresa = E.Nombre
        FROM LecturasSmart L WITH(NOLOCK)
        LEFT OUTER JOIN Trabajador T WITH(NOLOCK) ON T.IdTrabajador = L.IDTRABAJADOR AND T.IdEmpresa= L.IDEMPRESA
        INNER JOIN Contratos C WITH(NOLOCK) ON C.IdEmpresa=T.IdEmpresa AND T.IdTrabajador=C.IdTrabajador AND L.Fecha BETWEEN C.FECHAINICIO AND ISNULL(ISNULL(C.FECHATERMINO,C.FECHATERMINOC),GETDATE())
        INNER JOIN Oficio O WITH(NOLOCK) ON C.IdEmpresa=O.IdEmpresa AND C.IdOficio=O.IdOficio
        INNER JOIN TipoRegimen TR WITH(NOLOCK) ON TR.idtipo=C.idregimen
        INNER JOIN Zona Z WITH(NOLOCK) ON Z.IdEmpresa=T.IdEmpresa and Z.idZona=T.IdZonaLabores
        LEFT OUTER JOIN (
            SELECT ID=CAST([ID] AS nvarchar(35)),[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM bsis_rem_afr.[dbo].Estacion_Marcacion WITH(NOLOCK)
            UNION
            SELECT ID=CAST([ID] AS nvarchar(35)),[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Estacion_Marcacion WITH(NOLOCK)
            UNION
            SELECT [ID],[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Estacion_Marcacion_Prueba WITH(NOLOCK)
        ) E_INI ON CAST(E_INI.ID AS nvarchar(35)) = CAST(L.EstacionInicio AS nvarchar(35))
        LEFT OUTER JOIN (
            SELECT ID=CAST([ID] AS nvarchar(35)),[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM bsis_rem_afr.[dbo].Estacion_Marcacion WITH(NOLOCK)
            UNION
            SELECT ID=CAST([ID] AS nvarchar(35)),[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Estacion_Marcacion WITH(NOLOCK)
            UNION
            SELECT [ID],[TIPO_ESTACION],[NOMBRE_ESTACION]
            FROM [192.168.60.8\SQLEXPRESS].[Marcaciones].[dbo].Estacion_Marcacion_Prueba WITH(NOLOCK)
        ) E_FIN ON CAST(E_FIN.ID AS nvarchar(35)) = CAST(L.EstacionFinal AS nvarchar(35))
        LEFT OUTER JOIN TIPO_HORARIO TH WITH(NOLOCK) ON TH.IdEmpresa=C.IdEmpresa AND TH.IdTrabajador=C.IdTrabajador AND TH.FECHA = L.FECHA
        LEFT OUTER JOIN Horarios HO WITH(NOLOCK) ON HO.IdEmpresa=TH.IdEmpresa AND HO.IdHorario=TH.IdHorario
        INNER JOIN Empresa E WITH(NOLOCK) ON E.IdEmpresa= T.IdEmpresa
        WHERE L.fecha='13/04/2021' AND L.IdEmpresa  = $empresaId and C.IdRegimen in (1, 4) and O.Descripcion not in ('CHOFER', 'CASETERO DE RIEGO')
        ");

        $ruts = array_column($result, 'DNI');

        $result2 = DB::connection('sqlsrv2')->select("
            select
        ");

        return response()->json([
            'data' => $result
        ]);
    }

    private function esEstacionBus($nombreEstacion) {
        return strlen($nombreEstacion) === 7;
    }
}
