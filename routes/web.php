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
Route::resource('/especialidad','EspecialidadController')->names('especialidad');

// Rutas para usuarios
Route::resource('/usuarios','UsuariosController')->names('usuarios');

// Route::get('/usuarios','UsuariosController@index')->name('usuarios.index');
// Route::get('/usuarios/create','UsuariosController@create')->name('usuarios.create');
// Route::post('/usuarios','UsuariosController@store')->name('usuarios.store');
// Route::get('/usuarios/{usuario}/edit','UsuariosController@edit')->name('usuarios.edit');
// Route::delete('/usuarios/{usuario}','UsuariosController@destroy')->name('usuarios.destroy');
