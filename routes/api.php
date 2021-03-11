<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
});

Route::group(['prefix' => 'usuario'], function() {
    Route::get('/', 'UserController@get');
    Route::post('/', 'UserController@store');
    Route::get('/{usuario}/roles', 'UserController@roles');
    Route::put('/{usuario}/toggle-activate', 'UserController@toggleActivate');
    Route::put('/{usuario}', 'UserController@update');
});

Route::group(['prefix' => 'modulos'], function() {
    Route::get('/{modulo}/usuarios', 'ModulosController@getUsuarios');
});

Route::get('/empresa', 'EmpresasController@all');
Route::get('/incidencia', 'IncidenciaController@all');

Route::group(['prefix' => 'informes-descansos'], function () {
    Route::get('/', 'InformesDescansosController@get');
    Route::post('/', 'InformesDescansosController@store');
    Route::get('/{id}', 'InformesDescansosController@show');
    Route::put('/{id}', 'InformesDescansosController@update');
    Route::get('/{id}/exportar', 'InformesDescansosController@export');
});

Route::group(['prefix' => 'registros-descansos'], function () {
    Route::get('/export', 'RegistrosDescansosController@export');
    Route::post('/', 'RegistrosDescansosController@store');
    Route::delete('/{id}', 'RegistrosDescansosController@delete');
});

Route::group(['prefix' => 'actualizar-datos'], function() {
    Route::post('/por-empresa', 'ActualizarController@porEmpresa');
    Route::post('/por-empresa-2', 'ActualizarController@porEmpresa2');
    Route::post('/localidades', 'ActualizarController@localidades');
});

Route::group(['prefix' => 'trabajador'], function() {
    Route::post('/', 'TrabajadorController@create');
    Route::put('/', 'TrabajadorController@get');
    Route::put('/observados', 'TrabajadorController@getObservados');
    Route::post('/revision', 'TrabajadorController@revision');
    Route::put('/{id}/habilitar', 'TrabajadorController@habilitar');
    Route::get('/{rut}/horarios', 'TrabajadorController@getHorarios');
    Route::put('/{rut}/sctr', 'TrabajadorController@sctr');
    Route::group(['prefix' => 'reniec'], function() {
        Route::get('/{rut}', 'TrabajadorController@obtencionReniecIndividual');
        Route::post('/masiva', 'TrabajadorController@obtencionReniecMasiva');
    });
});

Route::group(['prefix' => 'banco'], function() {
    Route::get('/{empresa_id}', 'BancosController@get');
});

Route::group(['prefix' => 'zona-labor'], function() {
    Route::get('/{empresa_id}', 'ZonaLaborController@get');
    Route::get('/', 'ZonaLaborController@getAll');
});

Route::group(['prefix' => 'oficio'], function() {
    Route::post('/', 'OficioController@create');
    Route::get('/get-with-sctr', 'OficioController@getWithSctr');
    Route::get('/get-indexes-with-sctr/{empresa_id}', 'OficioController@getIndexesWithSctr');
    Route::get('/exportar/sctr', 'OficioController@exportarSctr');
    Route::put('/{id}/disable-sctr', 'OficioController@disableSctr');
});

Route::group(['prefix' => 'cuartel'], function() {
    Route::post('/', 'CuartelController@create');
    Route::get('/get-with-sctr', 'CuartelController@getWithSctr');
    Route::put('/{id}/disable-sctr', 'CuartelController@disableSctr');
    Route::get('/get-indexes-with-sctr/{empresa_id}', 'CuartelController@getIndexesWithSctr');
});

Route::group(['prefix' => 'contrato'], function() {
    Route::get('/{id}', 'ContratoController@show');
    Route::post('/', 'ContratoController@test');
    Route::post('/registro-masivo', 'ContratoController@registroMasivo');
    Route::post('/registro', 'ContratoController@registroIndividual');
    Route::post('/generar-pdf', 'ContratoController@generarPdf');
    Route::post('/generar-ficha-excel', 'ContratoController@generarFichaExcel');
    Route::delete('/{id}', 'ContratoController@delete');
    Route::get('/test/{contrato}', 'ContratoController@test');
});

Route::get('/cargas-pdf', 'CargaPdfController@get');
Route::get('/cargas-excel', 'CargaExcelController@get');

Route::group(['prefix' => 'cuenta'], function() {
    Route::post('/', 'CuentasController@create');
    Route::get('/{id}', 'CuentasController@show');
    Route::delete('/{id}', 'CuentasController@delete');
    Route::post('/get-all', 'CuentasController@getAll');
});

Route::group(['prefix' => 'eleccion-afp'], function() {
    Route::post('/', 'EleccionAfpController@create');
    Route::delete('/{id}', 'EleccionAfpController@delete');
    Route::post('/get-all', 'EleccionAfpController@getAll');
});

Route::group(['prefix' => 'atencion-reseteo-clave'], function() {
    Route::post('/', 'AtencionReseteoClaveController@create');
    Route::post('/get-all', 'AtencionReseteoClaveController@getAll');
    Route::post('/get-usuarios-carga', 'AtencionReseteoClaveController@getUsuariosCarga');
    Route::put('/resolver/{id}', 'AtencionReseteoClaveController@resolver');
    Route::delete('/{id}', 'AtencionReseteoClaveController@delete');

    Route::group(['prefix' => 'reportes'], function() {
        Route::post('/exportar', 'AtencionReseteoClaveController@export');
        Route::get('/data-resumen', 'AtencionReseteoClaveController@getDataResumen');
        Route::get('/resumen', 'AtencionReseteoClaveController@getResumen');
    });
});

Route::group(['prefix' => 'formulario-permiso'], function() {
    Route::get('/{id}', 'FormularioPermisoController@show');
    Route::post('/', 'FormularioPermisoController@create');
    Route::post('/get-all', 'FormularioPermisoController@getAll');
    Route::post('/calcular-horas', 'FormularioPermisoController@calcularHoras');
    Route::post('/get-usuarios-carga', 'FormularioPermisoController@getUsuariosCarga');
    Route::put('/toggle-goce/{id}', 'FormularioPermisoController@toggleGoce');
    Route::put('/marcar-firmado/{id}', 'FormularioPermisoController@marcarFirmado');
    Route::put('/marcar-enviado/{id}', 'FormularioPermisoController@marcarEnviado');
    Route::put('/marcar-recepcionado/{id}', 'FormularioPermisoController@marcarRecepcionado');
    Route::put('/marcar-cargado/{id}', 'FormularioPermisoController@marcarCargado');
    Route::delete('/{id}', 'FormularioPermisoController@delete');
    Route::delete('/{id}/admin', 'FormularioPermisoController@deleteAdmin');
});

Route::group(['prefix' => 'sancion'], function() {
    Route::get('/{id}', 'SancionesController@show');
    Route::post('/', 'SancionesController@create');
    Route::post('/get-usuarios-carga', 'SancionesController@getUsuariosCarga');
    Route::post('/get-all', 'SancionesController@getAll');
    Route::put('/marcar-enviado/{id}', 'SancionesController@marcarEnviado');
    Route::put('/marcar-subido/{id}', 'SancionesController@marcarSubido');
    Route::delete('/{id}', 'SancionesController@delete');

});

Route::group(['prefix' => 'covid'], function() {
    Route::get('/', 'CovidController@get');
    Route::get('/supervisores-sst', 'CovidController@getSupervisoresSst');
    Route::get('/estados', 'CovidController@getEstados');
    Route::get('/estados/analista', 'CovidController@getEstadosAnalista');

    Route::post('/generar-sanciones', 'CovidController@generarSanciones');
    Route::post('/sincronizar', 'CovidController@sync');
    Route::post('/terminar-proceso', 'CovidController@terminarProceso');
    Route::put('/toggle-valido/{tipo}', 'CovidController@toggleValido');
});

Route::group(['prefix' => 'pagos'], function() {
    Route::get('/', 'PagosController@get');
    Route::put('/{id}', 'PagosController@update');
    Route::get('/{rut}/trabajador', 'PagosController@getByTrabajador')->where('rut', '[0-9]+');

    Route::get('/get-pagados', 'PagosController@getPagados');
    Route::get('/get-pagados/tabla', 'PagosController@getPagadosTabla');
    Route::get('/get-rechazados', 'PagosController@getRechazados');
    Route::put('/toggle-rechazo/{tipo}', 'PagosController@toggleRechazo');
    Route::post('/terminar-proceso', 'PagosController@terminarProceso');

    Route::group(['prefix' => 'utilidades'], function() {
        Route::put('/sincronizar', 'PagosController@sincronizarDatosUtilidades');
    });

    Route::group(['prefix' => 'archivos-banco'], function() {
        Route::post('/validar', 'PagosController@validarArchivosBanco');
    });

    Route::post('/massive', 'PagosController@massiveCreate');
    Route::post('/importar', 'PagosController@importar');
    Route::post('/importar-tu-recibo', 'PagosController@importarTuRecibo');
    Route::post('/importar-tu-recibo/insertar', 'PagosController@insertarTuRecibo');
    Route::post('/programar-para-pago', 'PagosController@programarParaPago');
    Route::put('/programar-para-pago/reprogramar', 'PagosController@reprogramarParaPago');
    Route::get('/excel-banco', 'PagosController@testExcel');
    Route::post('/generar-archivos-banco', 'PagosController@generateArchivosBanco');
    Route::group(['prefix' => 'fechas-pagos'], function() {
        Route::get('/', 'PagosController@getFechasPago');
        Route::post('/descargar', 'PagosController@descargarArchivosAprobacion');
    });
    Route::put('/marcar/pagado-masivo', 'PagosController@marcarPagadoMasivo');
    Route::get('/montos-por-estado', 'PagosController@montosPorEstado');
    Route::get('/montos-por-estado-por-anio/{empresa_id}', 'PagosController@montosPorEstadoPorAnio');
    Route::get('/cantidad-pagos-por-dia/{empresa_id}', 'PagosController@cantidadPagosPorDia');

    Route::get('/test/{fecha_pago}', 'PagosController@test');
});

Route::group(['prefix' => 'consulta-trabajador'], function() {
    Route::get('/', 'ConsultaTrabajadorController@get');
    Route::post('/', 'ConsultaTrabajadorController@create');
});

Route::group(['prefix' => 'consulta-sctr'], function() {
    Route::get('/{usuario_id}', 'ConsultaSctrController@get');
    Route::post('/', 'ConsultaSctrController@create');
});

Route::group(['prefix' => 'corte-sctr'], function() {
    Route::post('/', 'CorteSctrController@create');
});

Route::group(['prefix' => 'archivo-banco'], function() {
    Route::post('/descargar', 'ArchivosBancoController@descargar');
    Route::get('/liquidaciones', 'ArchivosBancoController@liquidaciones');
});

Route::group(['prefix' => 'documentos-turecibo'], function() {
    Route::get('/', 'DocumentosTuReciboController@get');
    Route::post('/generar-archivo', 'DocumentosTuReciboController@generateJson');
    Route::post('/massive', 'DocumentosTuReciboController@massive');
    Route::get('/cantidad-firmados-dia', 'DocumentosTuReciboController@getCantidadFirmadosPorDia');
    Route::get('/cantidad-firmados-zona-labor', 'DocumentosTuReciboController@getCantidadPorZonaLabor');
    Route::get('/{rut}', 'DocumentosTuReciboController@getByTrabajador');
    Route::put('/{id}', 'DocumentosTuReciboController@update');
});

Route::group(['prefix' => 'corte-turecibo'], function() {
    Route::get('/get-last', 'CorteTureciboController@getLast');
});

Route::group(['prefix' => 'tipo-licencia'], function () {
    Route::get('/{empresaId}', 'TipoLicenciaController@get');
});

Route::group(['prefix' => 'bonos'], function () {
    Route::get('/', 'BonosController@get');
    Route::get('/{id}', 'BonosController@show');
    Route::post('/', 'BonosController@create');
    Route::get('/{bono}/planilla', 'BonosController@getPlanillaBono');
    Route::put('/{id}', 'BonosController@update');
    Route::delete('/{id}', 'BonosController@delete');
    Route::post('/exportar', 'BonosController@export');
});

Route::group(['prefix' => 'bonos-reglas'], function() {
    Route::get('/bono/{id}', 'BonosReglasController@getByBono');
    Route::post('/', 'BonosReglasController@create');
    Route::delete('/{id}', 'BonosReglasController@delete');
});

Route::group(['prefix' => 'bonos-condiciones-pagos'], function() {
    Route::post('/', 'BonosCondicionesPagosController@create');
    Route::get('/bono/{id}', 'BonosCondicionesPagosController@getLastByBono');
});

Route::group(['prefix' => 'cargas-bonos'], function() {
    Route::get('/', 'CargasBonosController@get');
    Route::delete('/{id}', 'CargasBonosController@delete');
});

Route::group(['prefix' => 'grupos-finiquitos'], function() {
    Route::get('/', 'GruposFiniquitosController@get');
    Route::post('/', 'GruposFiniquitosController@create');
    Route::put('/{id}', 'GruposFiniquitosController@update');
    Route::put('/{id}/set-state', 'GruposFiniquitosController@changeState');
    Route::put('/{id}/finiquitos', 'GruposFiniquitosController@updateFiniquitos');
    Route::get('/{id}', 'GruposFiniquitosController@find')->where('id', '[0-9]+');
    Route::get('/{id}/print', 'GruposFiniquitosController@print');
    Route::post('/{id}/delete', 'GruposFiniquitosController@delete');
    Route::post('/{id}/copy', 'GruposFiniquitosController@copy');
    Route::group(['prefix' => 'usuarios-zonas'], function() {
        Route::get('/', 'GruposFiniquitosController@getUsuariosZonas');
        Route::post('/', 'GruposFiniquitosController@createUsuariosZonas');
        Route::delete('/{usuario}/{zonaLabor}', 'GruposFiniquitosController@deleteUsuariosZonas');
    });
});

Route::group(['prefix' => 'finiquitos'], function() {
    Route::get('/', 'FiniquitosController@get');
    Route::post('/', 'FiniquitosController@create');
    Route::post('/import', 'FiniquitosController@import');
    Route::put('/{id}/state', 'FiniquitosController@changeState');
    Route::post('/{id}/delete', 'FiniquitosController@delete');
    Route::get('/estados', 'FiniquitosController@estados');
});

Route::group(['prefix' => 'tipos-ceses'], function() {
    Route::get('/', 'TiposCesesController@get');
});

Route::group(['prefix' => 'seguros-vida'], function() {
    Route::get('/', 'SegurosVidaController@get');
    Route::post('/', 'SegurosVidaController@create');
    Route::delete('/{id}', 'SegurosVidaController@delete');
});

Route::group(['prefix' => 'colores-fotocheck'], function() {
    Route::get('/', 'ColoresFotocheckController@get');
});

Route::group(['prefix' => 'motivos-fotocheck'], function() {
    Route::get('/', 'MotivosFotocheckController@get');
});

Route::group(['prefix' => 'motivos-planillas-manuales'], function() {
    Route::get('/', 'MotivosPlanillasManualesController@get');
});

Route::group(['prefix' => 'renovacion-fotocheck'], function() {
    Route::get('/', 'RenovacionesFotocheckController@get');
    Route::get('/resumen', 'RenovacionesFotocheckController@getResumen');
    Route::post('/', 'RenovacionesFotocheckController@create');
    Route::post('/planillas-manuales', 'RenovacionesFotocheckController@createPlanillasManuales');
    Route::post('/massive-update', 'RenovacionesFotocheckController@masiveUpdate');
    Route::put('/{id}', 'RenovacionesFotocheckController@update');
    Route::delete('/{id}', 'RenovacionesFotocheckController@delete');
});

Route::group(['prefix' => 'cortes-renovaciones-fotocheck'], function() {
    Route::get('/', 'CortesRenovacionesFotocheckController@get');
    Route::get('/{id}/registros', 'CortesRenovacionesFotocheckController@getRegistros');
    Route::get('/ultimo', 'CortesRenovacionesFotocheckController@getUltimo');
    Route::post('/', 'CortesRenovacionesFotocheckController@create');
    Route::put('/{id}/terminar', 'CortesRenovacionesFotocheckController@terminarProceso');
});

Route::group(['prefix' => 'planillas-manuales'], function() {
    Route::get('/', 'PlanillasManualesController@get');
    Route::post('/', 'PlanillasManualesController@create');
    Route::put('/{planilla}', 'PlanillasManualesController@update');
    Route::delete('/{planilla}', 'PlanillasManualesController@delete');
});

Route::group(['prefix' => 'importaciones-finiquitos'], function() {
    Route::get('/{importacionFiniquito}/export', 'ImportacionesFiniquitosController@export');
});

Route::group(['prefix' => 'sqlsrv'], function () {
    Route::group(['prefix' => 'trabajador'], function() {
        Route::get('/{rut}/{empresaId}', 'InformesDescansosController@getTrabajador')->where('empresaId', '[0-9]+');
        Route::get('/{rut}/finiquito', 'Sqlsrv\TrabajadoresController@getParaFiniquito');
    });

    Route::group(['prefix' => 'rutas'], function() {
        Route::get('/', 'Sqlsrv\RutasController@getAll');
    });

    Route::group(['prefix' => 'actividad-trabajador'], function() {
        Route::get('/{rut}/ultima', 'Sqlsrv\ActividadTrabajadorController@ultima');
        Route::post('/importar', 'Sqlsrv\ActividadTrabajadorController@importar');
    });

    Route::group(['prefix' => 'programacion-retornos'], function() {
        Route::get('/vacaciones', 'Sqlsrv\RetornosController@programacionVacaciones');
        Route::get('/spl', 'Sqlsrv\RetornosController@programacionSPL');
    });
});
/*
Route::group(['prefix' => 'sqlsrv'], function() {
    Route::get('/data/por-empresa', 'DataController@porEmpresa');
    Route::get('/data/localidades', 'DataController@localidades');
    Route::get('/trabajador/{dni}', 'TrabajadoresController@show');
    Route::get('/trabajador/{id_empresa}/{dni}/info', 'TrabajadoresController@info');
    Route::post('/trabajador/revision', 'TrabajadoresController@revision');
    Route::get('/departamento', 'DepartamentosController@get');
    Route::get('/departamento/{codigo}', 'DepartamentosController@show');
    Route::get('/departamento/{codigo}/provincias', 'DepartamentosController@provincias');
    Route::get('/provincia/{codigo}', 'ProvinciasController@show');
    Route::get('/provincia/{codigo}/distritos', 'ProvinciasController@distritos');
    Route::get('/distrito/{codigo}', 'DistritosController@show');
    Route::get('/tipo-zona/{id_empresa}', 'TipoZonaController@get');
    Route::get('/tipo-via/{id_empresa}', 'TipoViaController@get');
    Route::get('/nacionalidad/{id_empresa}', 'NacionalidadController@get');
    Route::get('/nacionalidad/{id_empresa}/{id_nacionalidad}', 'NacionalidadController@show');
    Route::get('/nivel_educativo/{id_empresa}', 'NivelEducativoController@get');
    Route::get('/nivel_educativo/{id_empresa}/{id_nivel_educativo}', 'NivelEducativoController@show');
    Route::get('/troncal/{id_empresa}', 'TroncalController@get');
    Route::get('/troncal/{id_empresa}/{codigo}', 'TroncalController@show');
    Route::get('/troncal/{id_empresa}/{codigo}/rutas', 'TroncalController@rutas');
    Route::get('/ruta/{id_empresa}/{codigo}', 'RutaController@get');
    Route::get('/ruta/{id_empresa}/{codigo_troncal}/{codigo_ruta}', 'RutaController@show');
    Route::get('/zona-labor/{id_empresa}', 'ZonaLaborController@get');
    Route::get('/oficio/{id_empresa}', 'OficioController@get');
    Route::get('/agrupacion/{id_empresa}', 'AgrupacionController@get');
    Route::get('/regimen', 'RegimenController@get');
    Route::get('/actividad/{id_empresa}', 'ActividadController@get');
    Route::get('/tipo-contrato/{id_empresa}', 'TipoContratoController@get');
    Route::get('/cuartel/{id_empresa}/{id_zona_labor}', 'CuartelController@get');
    Route::get('/labor/{id_empresa}/{id_actividad}', 'LaborController@get');
});*/
