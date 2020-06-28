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

Route::group(['prefix' => 'sistema'], function () {
    Route::post('/actualizar-datos/por-empresa', 'ActualizarController@porEmpresa');
    Route::post('/actualizar-datos/localidades', 'ActualizarController@localidades');
    Route::post('/trabajador', 'TrabajadorController@create');
    Route::put('/trabajador', 'TrabajadorController@get');
    Route::post('/trabajador/revision', 'TrabajadorController@revision');
    Route::post('/trabajador/test', 'TrabajadorController@test');

    Route::post('/contrato', 'ContratoController@test');
    Route::post('/contrato/registro-masivo', 'ContratoController@registroMasivo');
    Route::post('/contrato/test', 'ContratoController@test');
    Route::post('/contrato/generar-pdf', 'ContratoController@generarPdf');

    Route::get('/cargas-pdf', 'CargaPdfController@get');
});
