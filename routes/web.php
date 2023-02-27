<?php

use App\Http\Controllers\CargaLectivaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\wordController;
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

Route::get('/', [homeController::class, 'show'])->name('home');

//Route::get('/users',ShowUsers::class);
Route::get('/users', function () {
    return view('admin.users.index');
})->middleware('auth')->name('users');

Route::get('/declaracionesjuradasDocente', function () {
    return view('docente.declaracionjurada.index');
})->middleware('auth')->name('declaracionesjuradasDocente');

Route::get('/cargasLectivasDocente', function () {
    return view('docente.cargalectiva.index');
})->middleware('auth')->name('cargasLectivasDocente');

Route::get('/declaracionesjuradasJefeDepartamento', function () {
    return view('jefedepartamento.declaracionjurada.index');
})->middleware('auth')->name('declaracionesjuradasJefeDepartamento');

Route::get('/cargasLectivasJefeDepartamento', function () {
    return view('jefedepartamento.cargalectiva.index');
})->middleware('auth')->name('cargasLectivasJefeDepartamento');

Route::get('/cargasLectivasJefeDepartamento/{id}', [CargaLectivaController::class, 'index'])->name('cargalectiva.index');
Route::get('/cargasLectivasDocente/{id}', [CargaLectivaController::class, 'cargaLectivaLlenar'])->name('cargalectiva.llenar');
Route::get('/cargasLectivasDocenteHorario/{id}', [CargaLectivaController::class, 'cargaLectivaHorario'])->name('cargalectiva.horario');
//Route::get('/edit/{id}', [CargaLectivaController::class, 'edit'])->name('cargalectiva.edit');

//Rutas descargas de documentos
Route::post('dowloadDeclaracionJurada/{id}',[wordController::class, 'downloadDeclaracion'])->name('declaracionJurada.dowload');
Route::post('dowloadDeclaracionCargaHoraria/{id}',[wordController::class, 'downloadDeclaracionCargaHoraria'])->name('declaracionCargaHoraria.dowload');
Route::post('downloadHorario/{id}',[wordController::class, 'downloadHorario'])->name('horario.download');


//Rutas para el inicio de sesión
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
