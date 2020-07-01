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

    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('me', 'AuthController@me')->middleware('api.auth');
    });

    Route::group(['prefix' => 'actualizar-datos'], function() {
        Route::post('/por-empresa', 'ActualizarController@porEmpresa');
        Route::post('/por-empresa-2', 'ActualizarController@porEmpresa2');
        Route::post('/localidades', 'ActualizarController@localidades');
    });

    Route::group(['prefix' => 'trabajador'], function() {
        Route::post('/', 'TrabajadorController@create');
        Route::put('/', 'TrabajadorController@get');
        Route::get('/observados', 'TrabajadorController@getObservados');
        Route::post('/revision', 'TrabajadorController@revision');
        Route::put('/{id}/habilitar', 'TrabajadorController@habilitar');
        Route::post('/test', 'TrabajadorController@test');
    });

    Route::group(['prefix' => 'contrato'], function() {
        Route::post('/', 'ContratoController@test');
        Route::post('/registro-masivo', 'ContratoController@registroMasivo');
        Route::post('/test', 'ContratoController@test');
        Route::post('/generar-pdf', 'ContratoController@generarPdf');
    });

    Route::get('/cargas-pdf', 'CargaPdfController@get');
});
