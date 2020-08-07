<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Rutas para especialidades
Route::get('/especialidad/inactivos', 'EspecialidadController@inactivos')->name('especialidad.inactivos');
Route::get('/especialidad/restore/{id}', 'EspecialidadController@restore')->name('especialidad.restore');
Route::resource('/especialidad','EspecialidadController')->names('especialidad');

// Rutas para usuarios
Route::get('/usuarios/inactivos','UsuariosController@inactivos')->name('usuarios.inactivos');
Route::get('/usuarios/restore/{id}','UsuariosController@restore')->name('usuarios.restore');
// Route::get('/usuarios/destroy/{id}','UsuariosController@destroy')->name('usuarios.destroy');

Route::resource('/usuarios','UsuariosController')->names('usuarios');

Route::resource('/rol','RolController')->names('rol');

Route::resource('/perfil','PerfilController')->only(['show','edit','update'])->names('perfil');

/** Gestion de médicos */
Route::get('/medicos', 'MedicoController@index')->name('medicos.index');
/** Gestion de pacientes  */
Route::get('/pacientes', 'PacienteController@index')->name('pacientes.index');

// Route::resource('/horarios', 'HorarioController')->only(['show', 'edit','update'])->names('horarios');

Route::get('/horarios/{id}','HorarioController@edit')->name('horarios.edit');
Route::put('/horarios/{id}','HorarioController@update')->name('horarios.update');
