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
    Route::get('/test/{rut}', 'TrabajadorController@test');
    Route::group(['prefix' => 'reniec'], function() {
        Route::get('/{rut}', 'TrabajadorController@obtencionReniecIndividual');
        Route::post('/masiva', 'TrabajadorController@obtencionReniecMasiva');
    });
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
