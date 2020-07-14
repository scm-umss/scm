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
Route::get('/especialidades','EspecialidadController@index')->name('especialidades.index');
Route::get('/especialidades/create','EspecialidadController@create')->name('especialidades.create');
Route::post('/especialidades','EspecialidadController@store')->name('especialidades.store');
Route::get('/especialidades/{especialidad}/edit','EspecialidadController@edit')->name('especialidades.edit');
Route::put('/especialidades/{especialidad}','EspecialidadController@update')->name('especialidades.update');
Route::delete('/especialidades/{especialidad}','EspecialidadController@destroy')->name('especialidades.destroy');

// Rutas para usuarios
Route::get('/usuarios','UsuariosController@index')->name('usuarios.index');
Route::get('/usuarios/create','UsuariosController@create')->name('usuarios.create');
Route::post('/usuarios','UsuariosController@store')->name('usuarios.store');
Route::get('/usuarios/{usuario}/edit','UsuariosController@edit')->name('usuarios.edit');
Route::delete('/usuarios/{usuario}','UsuariosController@destroy')->name('usuarios.destroy');
