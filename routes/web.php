<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\backend\PersonaController;
use App\Http\Controllers\backend\SocioController;
use App\Http\Controllers\backend\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\ArbitroController;
use App\Http\Controllers\backend\AperturaranioController;
use App\Http\Controllers\backend\Cuentasxcobrarinscripciones;
use App\Http\Controllers\backend\Cuentasxcobrartarjetas;
use App\Http\Controllers\backend\Cuentasxcobrarmensualiades;
use App\Http\Controllers\backend\AperturarmesController;
use App\Http\Controllers\backend\Asistencia;
use App\Http\Controllers\backend\Canchas;
use App\Http\Controllers\backend\Cuentaxpagararbitrajes;
use App\Http\Controllers\backend\Cuentaxpagarcanchas;
use App\Http\Controllers\backend\Reporteinscripciones;
use App\Http\Controllers\backend\Reportekardex;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/todo-usuario', [UsuarioController::class, 'todoUsuario'])->name('todousuario');
/*Personas */
Route::resource('/personas', PersonaController::class)->names('personas');
Route::get('/personas/{id}/obtenerprovincia', [PersonaController::class, 'obtenerprovincia']);
Route::get('/personas/{id}/obtenerdistrito', [PersonaController::class, 'obtenerdistrito']);
/*Socios */
Route::resource('/socios', SocioController::class)->names('socios');
Route::get('/socios/{id}/savesocios', [SocioController::class, 'savesocios']);
Route::post('/socios/{id}/updatesocio', [SocioController::class, 'updatesocio'])->name('updatesocio');
/*Arbitros */
Route::resource('/arbitros', ArbitroController::class)->names('arbitros');
Route::post('/arbitros/{id}/savearbitros', [ArbitroController::class, 'savearbitros']);
Route::post('/arbitros/{id}/updatearbitro', [ArbitroController::class, 'updatearbitro'])->name('updatearbitro');
/*Aperturar año */
Route::resource('/aperturaranios', AperturaranioController::class)->names('aperturaranios');
Route::post('/aperturaranios/{id}/saveaperturaranios', [AperturaranioController::class, 'saveaperturaranios']);
/*Aperturar Mes */
Route::resource('/aperturarmes', AperturarmesController::class)->names('aperturarmes');
Route::post('/aperturarmes/{id}/saveaperturarmes', [AperturarmesController::class, 'saveaperturarmes']);
/*Cuentas x Cobrar Inscripción */
Route::resource('/cuentasxcobrarinscripciones', Cuentasxcobrarinscripciones::class)->names('cuentasxcobrarinscripciones');
Route::post('/cuentasxcobrarinscripciones/{id}/savecobroinscripcion', [Cuentasxcobrarinscripciones::class, 'savecobroinscripcion'])->name('savecobroinscripcion');
Route::post('/cuentasxcobrarinscripciones/{id}/vercuentaxcobrar', [Cuentasxcobrarinscripciones::class, 'vercuentaxcobrar'])->name('vercuentaxcobrar');
/*Cuentas x Cobrar Tarjetas */
Route::resource('/cuentasxcobrartarjetas', Cuentasxcobrartarjetas::class)->names('cuentasxcobrartarjetas');
/*Cuentas x Cobrar cuota Mensual */
Route::resource('/cuentasxcobrarmensualidades', Cuentasxcobrarmensualiades::class)->names('cuentasxcobrarmensualidades');
/*Asistencias */
Route::resource('/asistencias', Asistencia::class)->names('asistencias');
Route::post('/asistencias/{id}/saveaperturarpartido', [Asistencia::class, 'saveaperturarpartido'])->name('saveaperturarpartido');
Route::post('/asistencias/{id}/validaraperturarpartido', [Asistencia::class, 'validaraperturarpartido'])->name('validaraperturarpartido');
Route::get('/asistencias/{id}/registrarasistencia', [Asistencia::class, 'registrarasistencia'])->name('registrarasistencia');
Route::get('/asistencias/{id}/eliminarasistencia', [Asistencia::class, 'eliminarasistencia'])->name('eliminarasistencia');
Route::post('/asistencias/{id}/saveasistencia', [Asistencia::class, 'saveasistencia'])->name('saveasistencia');
Route::get('/asistencias/{id}/registrarpartido', [Asistencia::class, 'registrarpartido'])->name('registrarpartido');
Route::post('/asistencias/{id}/asistenciasocio', [Asistencia::class, 'asistenciasocio'])->name('asistenciasocio');
Route::post('/asistencias/{id}/saveasistenciasocio', [Asistencia::class, 'saveasistenciasocio'])->name('saveasistenciasocio');
Route::post('/asistencias/{id}/saveasistenciafalta', [Asistencia::class, 'saveasistenciafalta'])->name('saveasistenciafalta');
Route::post('/asistencias/{id}/saveasistenciagandor', [Asistencia::class, 'saveasistenciagandor'])->name('saveasistenciagandor');
Route::post('/asistencias/{id}/saveterminarpartido', [Asistencia::class, 'saveterminarpartido'])->name('saveterminarpartido');
/*Canchas */
Route::resource('/canchas', Canchas::class)->names('canchas');
/*Cuentas x Pagar Arbitraje */
Route::resource('/cuentaxpagararbitrajes', Cuentaxpagararbitrajes::class)->names('cuentaxpagararbitrajes');
/*Cuentas x Pagar Cancha */
Route::resource('/cuentaxpagararcanchas', Cuentaxpagarcanchas::class)->names('cuentaxpagararcanchas');
Route::resource('/reporteinscripciones', Reporteinscripciones::class)->names('reporteinscripciones');
/**Reporte Kardex */
Route::resource('/reportekardex', Reportekardex::class)->names('reportekardex');