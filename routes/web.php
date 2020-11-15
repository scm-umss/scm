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
Route::resource('/especialidad', 'EspecialidadController')->names('especialidad');

// Rutas para usuarios
Route::get('/usuarios/inactivos', 'UsuariosController@inactivos')->name('usuarios.inactivos');
Route::get('/usuarios/restore/{id}', 'UsuariosController@restore')->name('usuarios.restore');
// Route::get('/usuarios/destroy/{id}','UsuariosController@destroy')->name('usuarios.destroy');

Route::resource('/usuarios', 'UsuariosController')->names('usuarios');

Route::get('/roles', 'RolController@index');

// Route::resource('/perfil', 'PerfilController')->only(['show', 'edit', 'update'])->names('perfil');

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

/** Gestion de citas Admin */
/** Rspuesta JSON */
// medicos por especialidad
Route::get('/citas/especialidades', 'DatosController@getEspecialidades');
Route::get('/especialidad/{especialidad}/medicosjson', 'DatosController@getMedicosJson');
Route::get('/especialidad/{especialidad}/medicosjsoneditar', 'DatosController@getMedicosJsonEditar');
// Horarios de cada medico API JSON
Route::get('/horasmedico', 'DatosController@horasMedico');
//Reportes
Route::get('/reportes/pacientes', 'ReportesController@pacientes')->name('reportes.pacientes');
Route::get('/reportes/estado/citas', 'ReportesController@estadoCitas')->name('reportes.estadocitas');
Route::get('/reportes/especialidad/citas', 'ReportesController@especialidadCitas')->name('reportes.especialidadcitas');
Route::get('/reportes/citas/medico', 'ReportesController@citasMedico')->name('reportes.citasmedico');

Route::get('/citas/{paciente}/agendar', 'CitaController@agendarCita')->name('citas.agendar');

//Route::get('/citas/{paciente}/edit', 'CitaController@edit')->name('citas.edit');
// Route::get('/admin/citas', 'Admin\CitaController@index')->name('admin.citas.index');
// Route::get('/admin/citas/create', 'Admin\CitaController@create')->name('admin.citas.create');

/** Gestion de citas cliente */

Route::get('/citas/pendientes', 'CitaController@pendientes')->name('citas.pendientes');
Route::get('/citas/confirmadas', 'CitaController@confirmadas')->name('citas.confirmadas');
Route::get('/citas/historial', 'CitaController@historial')->name('citas.historial');

Route::post('/citas/{cita}/confirmar', 'CitaController@postConfirmar')->name('citas.confirmar');
Route::post('/citas/{cita}/cancelar', 'CitaController@postCancelar')->name('citas.cancelar');
Route::post('/citas/{cita}/atendido', 'CitaController@postAtendido')->name('citas.atendido');
Route::resource('/citas', 'CitaController')->names('citas');
// listar medicos por especialidad
Route::get('/especialidad/{especialidad}/medicos', 'CitaController@getMedicos')->name('citas.medicos');
// Vista para listar horario por medico
Route::get('/horario/{medico}/medico/{especialidad}', 'CitaController@horario')->name('citas.horario');

