<?php

use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Pages
 */
Route::get('/login', 'Web\ViewController@login');

Route::group(['middleware' => 'web.auth'], function() {
    Route::get('/', 'Web\ViewController@panel');
    Route::get('/perfil', 'Web\ViewController@perfil');
    Route::get('/ingresos', 'Web\ViewController@index');
    Route::get('/usuarios', 'Web\ViewController@usuarios');
    Route::get('/trabajadores', 'Web\ViewController@trabajadores');
    Route::get('/registro-individual', 'Web\ViewController@registroIndividual');
    Route::get('/registro-individual/editar/{id}', 'Web\ViewController@editarRegistroIndividual');
    Route::get('/registro-masivo', 'Web\ViewController@registorMasivo');
    Route::get('/cuentas', 'Web\ViewController@cuentas');
    Route::get('/cuentas/editar/{id}', 'Web\ViewController@editarCuenta');
    Route::get('/eleccion-afp', 'Web\ViewController@afp');
    Route::get('/formularios-permisos', 'Web\ViewController@permisos');
    Route::get('/formularios-permisos/editar/{id}', 'Web\ViewController@editarPermiso');
    Route::get('/atencion-cambio-clave', 'Web\ViewController@atencionReseteoClave');

    Route::group(['prefix' => 'sanciones'], function() {
        Route::get('/', 'Web\ViewController@sanciones');
        Route::get('/editar/{id}', 'Web\ViewController@editarSancion');
        Route::get('/reportes', 'Web\ViewController@sancionesReportes');
        Route::get('/desvinculaciones', 'Web\ViewController@sancionesDesvinculaciones');
    });

    Route::group(['prefix' => 'consulta-trabajadores'], function() {
        Route::get('/', 'Web\ViewController@consultaTrabajadores');
        Route::get('/historial-busqueda', 'Web\ViewController@historialConsultaTrabajadores');
    });

    Route::group(['prefix' => 'liquidaciones-utilidades'], function() {
        Route::get('/', 'Web\ViewController@liquidaciones');
        Route::get('/importacion', 'Web\ViewController@liquidacionesImportacion');
        Route::get('/consulta', 'Web\ViewController@liquidacionesConsulta');
        Route::get('/l', 'Web\ViewController@liquidacionesL');
        Route::get('/u', 'Web\ViewController@liquidacionesU');
    });

    Route::group(['prefix' => 'ficha'], function() {
        Route::get('/{contrato}', 'ContratoController@verFichaIngreso');
        Route::get('/cambio-cuenta/{cuenta}', 'CuentasController@verFichaCuenta');
        Route::get('/eleccion-afp/{eleccion_afp}', 'EleccionAfpController@verFicha');
        Route::get('/formulario-permiso/{formularioPermiso}', 'FormularioPermisoController@verFicha');
        Route::get('/sancion/{sancion}', 'SancionesController@verFicha');
    });

    Route::group(['prefix' => 'descargar'], function() {
        Route::post('/', 'Web\ExportController@descargar');
        Route::post('/observados', 'Web\TrabajadorController@descargarObservado');
        Route::post('/cuentas', 'Web\CuentasController@descargarCuentas');
        Route::post('/elecciones-afp', 'Web\EleccionAfpController@descargarEleccionesAfp');
        Route::post('/formularios', 'Web\FormularioPermisoController@descargar');
    });
});

Route::post('/login', 'Web\AuthController@login');
Route::post('/logout', 'Web\AuthController@logout');
