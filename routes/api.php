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
    Route::put('/{usuario}/toggle-activate', 'UserController@toggleActivate');
    Route::put('/{usuario}', 'UserController@update');
});

Route::get('/empresa', 'EmpresasController@all');
Route::get('/incidencia', 'IncidenciaController@all');

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

Route::group(['prefix' => 'finiquitos'], function() {
    Route::get('/', 'LiquidacionesController@get');
    Route::post('/massive', 'LiquidacionesController@massiveCreate');
    Route::post('/importar', 'LiquidacionesController@importar');
    Route::post('/importar-tu-recibo', 'LiquidacionesController@importarTuRecibo');
    Route::post('/programar-para-pago', 'LiquidacionesController@programarParaPago');
    Route::get('/excel-banco', 'LiquidacionesController@testExcel');
    Route::post('/generar-archivos-banco', 'LiquidacionesController@generateArchivosBanco');
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
    Route::get('/{rut}', 'DocumentosTuReciboController@getByTrabajador');
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
