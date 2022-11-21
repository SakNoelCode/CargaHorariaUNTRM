<?php

use App\Http\Controllers\homeController;
use App\Http\Livewire\EditDocente;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowUsers;

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

Route::get('/', [homeController::class,'show'])->name('home');

//Route::get('/users',ShowUsers::class);
Route::get('/users',function(){
    return view('admin.users.index');
})->middleware('auth')->name('users');

//Route::get('/editarusuario/{id}/{tipo}',EditDocente::class)->name('docente.edit');

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
