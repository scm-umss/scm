<?php

use Illuminate\Support\Facades\Auth;
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

Route::resource('/rol', 'RolController')->names('rol');

Route::resource('/perfil', 'PerfilController')->only(['show', 'edit', 'update'])->names('perfil');

/** Gestion de médicos */
Route::get('/medicos', 'MedicoController@index')->name('medicos.index');
/** Gestion de pacientes  */
Route::get('/pacientes', 'PacienteController@index')->name('pacientes.index');

// Route::resource('/horarios', 'HorarioController')->only(['show', 'edit','update'])->names('horarios');

Route::get('/horarios/{medico}', 'HorarioController@edit')->name('horarios.edit');
Route::put('/horarios/{medico}', 'HorarioController@update')->name('horarios.update');
/** Gestion de médicos */
Route::get('/medicos', 'MedicoController@index')->name('medicos.index');
/** Gestion de pacientes  */
Route::get('/pacientes', 'PacienteController@index')->name('pacientes.index');
Route::get('/pacientes/create', 'PacienteController@create')->name('pacientes.create');

/** Gestion de citas Admin */
Route::get('/citas/especialidades', 'CitaController@getEspecialidades');
// Route::get('/admin/citas', 'Admin\CitaController@index')->name('admin.citas.index');
// Route::get('/admin/citas/create', 'Admin\CitaController@create')->name('admin.citas.create');
/** Gestion de citas cliente */
Route::resource('/citas', 'CitaController')->names('citas');
// listar medicos por especialidad
Route::get('/especialidad/{especialidad}/medicos', 'CitaController@getMedicos')->name('citas.medicos');
// Vista para listar horario por medico
Route::get('/horario/{medico}', 'CitaController@horario')->name('citas.horario');
// Horarios de cada medico API JSON
Route::get('/horasmedico', 'CitaController@horasMedico');
