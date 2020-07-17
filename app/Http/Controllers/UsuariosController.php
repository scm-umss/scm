<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuariosRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use App\Rol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = User::find(1);
        // $ur = $u->roles()->slug;
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios', 'u'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {

        // dd($request->all());
        $usuario = new User();
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('password'));
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->ci = $request->input('ci');
        $usuario->telefono = $request->input('telefono');
        // $usuario->rol = $request->input('rol');
        $usuario->estado = $request->input('estado');

        $usuario->save();
        $usuario->roles()->sync([$request->input('rol')]);
        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $roles = Rol::orderBy('nombre', 'ASC')->get();
        // dd($usuario->roles[0]->nombre);
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuariosUpdateRequest $request, User $usuario)
    {

        // dd( $usuario);
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->telefono = $request->input('telefono');
        // $usuario->rol = $request->input('rol');
        $usuario->estado = $request->input('estado');
        if($request->password){
            $usuario->password = Hash::make($request->input('password'));
            // dd($usuario->password);
        }
        $usuario->save();
        $usuario->roles()->sync([$request->input('rol')]);
        // $usuario->update();

        return redirect()->route('usuarios.index');
    }

    public function estadoUsaurio(Request $request){
        $estadoUsuario = $request->estado;
        dd($estadoUsuario);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {

    }
}
