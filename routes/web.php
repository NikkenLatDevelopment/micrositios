<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\generalController;

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

Route::get('/seguimientoOrganizacion/{cod}', [generalController::class, 'index_seguimiento_organizacion'])->name('seguimiento-organizacion.index');
Route::post('/getSeguimientoOrganizacion', [generalController::class, 'get_seguimiento_organizacion_personal'])->name('seguimiento-organizacion.get');
Route::post('/getSeguimientoOrganizacionArbol', [generalController::class, 'get_seguimiento_organizacion_arbol_completo'])->name('seguimientoOrganizacion.getArvol');

Route::get('/seguimientoStaff', [generalController::class, 'index_seguimiento_staff'])->name('seguimiento-staff.index');
Route::get('/seguimientoPersonal', [generalController::class, 'index_seguimiento_personal'])->name('seguimiento-personal.index');
