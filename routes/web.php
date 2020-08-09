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
    Route::get('/panel', 'Web\ViewController@panel');
    Route::get('/', 'Web\ViewController@index');
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
    Route::get('/sanciones', 'Web\ViewController@sanciones');

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
    });
});

Route::post('/login', 'Web\AuthController@login');
Route::post('/logout', 'Web\AuthController@logout');


Route::get('/test-memo', function() {

    $memorandum = (object) [
        'id' => 1,
        'empresa_id' => 9,
        'trabajador_id' => 1,
        'empresa' => Empresa::find(9),
        'trabajador' => Trabajador::find(1)
    ];

    $data = [
        'memorandum' => $memorandum,
        'codigo' => 4 . '@' . $memorandum->id
    ];

    $pdf = \PDF::setOptions([
        'images' => true
    ])->loadView('documents.memorandum.index', $data);

    $filename = $memorandum->trabajador->apellido_paterno . '-' . $memorandum->trabajador->apellido_materno . '-' . $memorandum->trabajador->rut . '-' . $memorandum->empresa->shortname . '-MEMORANDUM.pdf';

    return $pdf->stream($filename);
});
