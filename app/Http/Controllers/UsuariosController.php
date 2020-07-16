<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ap_paterno' => 'required|string|max:255',
            'ap_materno' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'rol' => 'required',
            'estado' => 'required',
        ];

        $message = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener más de 5 caracteres'
            // los mensajes van aqui
        ];

        $this->validate($request, $rules);

        $usuario = new User();
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->telefono = $request->input('telefono');
        $usuario->rol = $request->input('rol');
        $usuario->estado = $request->input('estado');

        $usuario->save();

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
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'ap_paterno' => 'required|string|max:255',
            'ap_materno' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'rol' => 'required',
            'estado' => 'required',
        ];

        $message = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener más de 5 caracteres'
            // los mensajes van aqui
        ];

        $this->validate($request, $rules);

        //$usuario = new User();
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        if ($request->input('password') <> '') {
            $usuario->password = $request->input('password');
        }        
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->telefono = $request->input('telefono');
        $usuario->rol = $request->input('rol');
        $usuario->estado = $request->input('estado');

        $usuario->update();

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
