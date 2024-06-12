<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\generalController;
use App\Exports\SeguimientoStaffExport;
use Maatwebsite\Excel\Facades\Excel;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/seguimientoOrganizacion/{cod}', [generalController::class, 'index_seguimiento_organizacion'])->name('seguimiento-organizacion.index');

Route::post('/getSeguimientoOrganizacion', [generalController::class, 'get_seguimiento_organizacion_personal'])->name('seguimientoOrganizacion.get');
Route::post('/getSeguimientoOrganizacionArbol', [generalController::class, 'get_seguimiento_organizacion_arbol_completo'])->name('seguimientoOrganizacion.getArbol');

Route::get('/seguimientoStaff', [generalController::class, 'index_seguimiento_staff'])->name('seguimiento-staff.index');
Route::post('/getSeguimientoStaff', [generalController::class, 'get_seguimiento_staff'])->name('seguimiento-staff.get');

Route::get('/seguimientoPersonal/{cod}', [generalController::class, 'index_seguimiento_personal'])->name('seguimiento-personal.index');
Route::get('/seguimientoOrganizacionGen', [generalController::class, 'seguimientoOrganizacionGen']);

// Route::get('/export-seguimiento-staff', function () {
//     return (new SeguimientoStaffExport)->download('seguimiento_staff.xlsx');
// })->name('export.seguimiento-staff');
