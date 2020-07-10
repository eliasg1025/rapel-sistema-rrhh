<?php

use Illuminate\Http\Request;
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
Route::get('/', 'Web\ViewController@index');
Route::get('/login', 'Web\ViewController@login');
Route::get('/usuarios', 'Web\ViewController@usuarios');
Route::get('/trabajadores', 'Web\ViewController@trabajadores');
Route::get('/registro-individual', 'Web\ViewController@registroIndividual');
Route::get('/registro-masivo', 'Web\ViewController@registorMasivo');


Route::post('/login', 'Web\AuthController@login');

Route::get('/ficha/{contrato}', 'ContratoController@verFichaIngreso');
Route::get('/test', 'ContratoController@test');
