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
    Route::get('/', 'Web\ViewController@index');
    Route::get('/perfil', 'Web\ViewController@perfil');

    Route::group(['prefix' => 'ingresos'], function() {
        Route::get('/', 'Web\IngresosController@index');
        Route::get('/trabajadores', 'Web\IngresosController@trabajadores');
        Route::get('/registro-individual', 'Web\IngresosController@registroIndividual');
        Route::get('/registro-individual/editar/{id}', 'Web\IngresosController@editarRegistroIndividual');
        Route::get('/registro-masivo', 'Web\IngresosController@registorMasivo');
    });

    Route::group(['prefix' => 'usuarios'], function() {
        Route::get('/', 'Web\UsuariosController@index');
        Route::get('/roles', 'Web\UsuariosController@roles');
    });

    Route::group(['prefix' => 'cuentas'], function() {
        Route::get('/', 'Web\CuentasController@index');
        Route::get('/editar/{id}', 'Web\CuentasController@editarCuenta');
    });

    Route::group(['prefix' => 'eleccion-afp'], function() {
        Route::get('/', 'Web\AfpController@index');
    });

    Route::group(['prefix' => 'atencion-cambio-clave'], function() {
        Route::get('/', 'Web\AtencionReseteoClaveController@index');
    });

    Route::group(['prefix' => 'formularios-permisos'], function() {
        Route::get('/', 'Web\FormulariosPermisosController@index');
        Route::get('/editar/{id}', 'Web\FormulariosPermisosController@editar');
    });

    Route::group(['prefix' => 'perfil'], function () {
        Route::get('/', 'Web\PerfilController@index');
        Route::post('/change-password', 'Web\PerfilController@changePassword');
    });

    Route::group(['prefix' => 'aplicacion'], function () {
        Route::get('/', 'Web\AplicacionController@index');
        Route::get('/sincronizar', 'Web\AplicacionController@sync');
        Route::group(['prefix' => 'lecturas-sueldos'], function() {
            Route::get('/historial', 'Web\AplicacionController@lecturasHisorial');
            Route::get('/observaciones', 'Web\AplicacionController@lecturasObservaciones');
        });
    });

    Route::group(['prefix' => 'descansos-medicos'], function () {
        Route::get('/', 'Web\DescansosMedicosController@index');
        Route::get('/registrar-informes', 'Web\DescansosMedicosController@registrarInformes');
        Route::get('/registrar-informes/{id}', 'Web\DescansosMedicosController@registrarInformesRegistros');
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

    Route::group(['prefix' => 'bonos'], function() {
        Route::get('/', 'Web\BonosController@index');
        Route::get('/editar/{id}', 'Web\BonosController@editar');
    });

    Route::group(['prefix' => 'finiquitos', 'middleware' => 'module:finiquitos'], function() {
        Route::get('/', 'Web\FiniquitosMasivosController@index');
    });

    Route::group(['prefix' => 'ficha'], function() {
        Route::get('/{contrato}', 'ContratoController@verFichaIngreso');
        Route::get('/cambio-cuenta/{cuenta}', 'CuentasController@verFichaCuenta');
        Route::get('/eleccion-afp/{eleccion_afp}', 'EleccionAfpController@verFicha');
        Route::get('/formulario-permiso/{formularioPermiso}', 'FormularioPermisoController@verFicha');
        Route::get('/sancion/{sancion}', 'SancionesController@verFicha');
        Route::get('/descanso-medico/{informe}', 'InformesDescansosController@verFicha');
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


Route::get('/test-pusher', function() {
    event(new App\Events\SendNotification('eguere', 'hola'));
    return 'hi';
});

Route::get('/test', function() {
    return md5(sha1("yl.1234"));
});
