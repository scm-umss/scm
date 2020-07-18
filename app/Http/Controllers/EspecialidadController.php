<?php

namespace App\Http\Controllers;

use App\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especialidades = Especialidad::all();
        return view('especialidad.index', compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('especialidad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'nombre' => 'required|min:5'
        ];

        $message = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener más de 5 caracteres'
        ];
        $this->validate($request, $rules, $message);

        $especialidad = new Especialidad();
        $especialidad->nombre = $request->input('nombre');
        $especialidad->descripcion = $request->input('descripcion');

        $especialidad->save();

        return redirect()->route('especialidad.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function show(Especialidad $especialidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Especialidad $especialidad)
    {
        return view('especialidad.edit', compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Especialidad $especialidad)
    {
        // dd($request->all());
        // Reglas de validación
        $rules = [
            'nombre' => 'required|min:5'
        ];

        // Validación de datos para actualizar
        $this->validate($request, $rules);

        $especialidad->descripcion = $request['descripcion'];
        $especialidad->save();
        return redirect()->route('especialidad.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Especialidad  $especialidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();
        return redirect()->route('especialidad.index');
    }
}
