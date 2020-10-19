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
    Route::get('/cuentas', 'Web\CuentasController@index');
    Route::get('/cuentas/editar/{id}', 'Web\CuentasController@editarCuenta');
    Route::get('/eleccion-afp', 'Web\ViewController@afp');
    Route::get('/formularios-permisos', 'Web\ViewController@permisos');
    Route::get('/formularios-permisos/editar/{id}', 'Web\ViewController@editarPermiso');
    Route::get('/atencion-cambio-clave', 'Web\ViewController@atencionReseteoClave');

    Route::group(['prefix' => 'perfil'], function () {
        Route::get('/', 'Web\PerfilController@index');
        Route::post('/change-password', 'Web\PerfilController@changePassword');
    });

    Route::group(['prefix' => 'aplicacion'], function () {
        Route::get('/', 'Web\AplicacionController@index');
    });

    Route::group(['prefix' => 'estado-documentos'], function() {
        Route::get('/', 'Web\EstadoDocumentosController@index');
        Route::get('/boletas', 'Web\EstadoDocumentosController@boletas');
        Route::get('/prorrogas', 'Web\EstadoDocumentosController@prorrogas');
    });

    Route::group(['prefix' => 'sctr'], function() {
        Route::get('/', 'Web\SctrController@consultas');
        Route::get('/habilitar', 'Web\SctrController@habilitar');
        Route::get('/reportes', 'Web\SctrController@reportes');
    });

    Route::group(['prefix' => 'sanciones'], function() {
        Route::get('/', 'Web\SancionesController@index');
        Route::get('/editar/{id}', 'Web\SancionesController@editar');
        Route::get('/reportes', 'Web\SancionesController@reportes');
        Route::get('/desvinculaciones', 'Web\SancionesController@desvinculaciones');
        Route::group(['prefix' => 'sst'], function() {
            Route::get('/supervisor', 'Web\SancionesController@supervisorSst');
            Route::get('/analista', 'Web\SancionesController@analistaSst');
        });
        Route::group(['prefix' => 'rrhh'], function() {
            Route::get('/supervisor', 'Web\SancionesController@supervisorRrhh');
        });
    });

    Route::group(['prefix' => 'consulta-trabajadores'], function() {
        Route::get('/', 'Web\ViewController@consultaTrabajadores');
        Route::get('/historial-busqueda', 'Web\ViewController@historialConsultaTrabajadores');
    });

    Route::group(['prefix' => 'liquidaciones-utilidades'], function() {
        Route::get('/', 'Web\LiquidacionesController@index');
        //Route::get('/importacion', 'Web\LiquidacionesController@liquidacionesImportacion');
        Route::get('/consulta', 'Web\LiquidacionesController@consulta');

        Route::group(['prefix' => 'l'], function() {
            Route::get('/', 'Web\LiquidacionesController@liquidaciones');
            Route::get('/pagados', 'Web\LiquidacionesController@liquidacionesPagados');
            Route::get('/rechazos', 'Web\LiquidacionesController@liquidacionesRechazos');
        });

        Route::group(['prefix' => 'u'], function() {
            Route::get('/', 'Web\LiquidacionesController@utilidades');
            Route::get('/pagados', 'Web\LiquidacionesController@utilidadesPagados');
            Route::get('/rechazos', 'Web\LiquidacionesController@utilidadesRechazos');
        });
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
