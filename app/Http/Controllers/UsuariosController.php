<?php

namespace App\Http\Controllers;

use App\Rol;
use App\User;
use App\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Intervention\Image\Facades\Image;
use App\Http\Requests\UsuariosRequest;
use App\Http\Requests\UsuariosUpdateRequest;

//use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['admin'])->except(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre = $request->get('busqueda');
        $ap_paterno = $request->get('busqueda');
        $ap_materno = $request->get('busqueda');

        $usuarios = User::with('roles')
                    ->buscar($nombre, $ap_paterno, $ap_materno)
                    ->paginate(10);

        // $usuarios = User::with('roles')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', User::class);

        $roles = Rol::orderBy('nombre', 'ASC')->get();
        $especialidades = Especialidad::orderBy('nombre', 'ASC')->get();
        return view('usuarios.create', compact('roles', 'especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {
        $this->authorize('create', User::class);

        $iNombre = $request->input('nombre');
        $iPaterno = $request->input('ap_paterno');
        $iMaterno = $request->input('ap_materno');
        $iNacimiento = $request->input('fecha_nacimiento');
        // $fecha = explode("-",$iNacimiento);

        $matricula = strtoupper(substr($iNombre,0,1) . substr($iPaterno,0,1) . substr($iMaterno,0,1) .
        '-' . str_replace('-','',$iNacimiento));
        $usuario = new User();
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('password'));
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->ci = $request->input('ci');
        $usuario->matricula = $matricula;
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->telefono = $request->input('telefono');

        if ($request['imagen']) {
            //obtener imagen
            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            //Resize de la imagen con intervention image
            //$img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(500,500);
            //$img->save();

            // Crear un arreglo de imagen
            //$array_imagen = ['imagen' => $ruta_imagen];
            $usuario->imagen = $ruta_imagen;
        }

        $usuario->save();
        $usuario->roles()->sync($request->roles);
        $usuario->especialidades()->sync($request->especialidades);

        return redirect()->route('usuarios.index')->with('status', 'Usuario creado exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        $this->authorize('view', $usuario);
        // $roles = Rol::pluck('slug','id');
        $citas_confirmadas = $usuario->citasConfirmadas;
        // $rol = $usuario->roles[0]]->slug;
        return view('usuarios.show', compact('usuario','citas_confirmadas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $this->authorize('update', $usuario);

        $roles = Rol::orderBy('nombre', 'ASC')->get();
        $especialidades = Especialidad::orderBy('nombre', 'ASC')->get();

        return view('usuarios.edit', compact('usuario', 'roles', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuariosRequest $request, User $usuario)
    {
        $this->authorize('update', $usuario);

        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->ap_paterno = $request->input('ap_paterno');
        $usuario->ap_materno = $request->input('ap_materno');
        $usuario->ci = $request->input('ci');
        $usuario->telefono = $request->input('telefono');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        if ($request->password) {
            $usuario->password = Hash::make($request->input('password'));
        }
        if ($request['imagen']) {
            //obtener imagen
            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            //Resize de la imagen con intervention image
            //$img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(500,500);
            //$img->save();

            // Crear un arreglo de imagen
            //$array_imagen = ['imagen' => $ruta_imagen];
            $usuario->imagen = $ruta_imagen;
        }
        $usuario->save();
        $usuario->roles()->sync($request->roles);
        $usuario->especialidades()->sync($request->especialidades);
        if (!$usuario->tieneRol(['medico'])) {
            $usuario->especialidades()->detach();
        }
        // $usuario->update();
        return redirect()->route('usuarios.show',compact('usuario'))->with('status', 'Usuario actualizado exitosamente!');
        // return redirect()->route('usuarios.index')->with('status', 'Usuario actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 'Eliminando-...';
        $usuario = User::findOrFail($id);
        $this->authorize('delete', $usuario);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('status', 'Usuario dado de baja exitosamente!.');
    }

    public function inactivos()
    {
        $usuarios = User::onlyTrashed()->get();

        return view('usuarios.inactivos', compact('usuarios'));
    }
    public function restore($id)
    {
        // $usuario = User::withTrashed()->where('id', $id)->first();
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.inactivos')->with('status', 'Usuario restaurado exitosamente!');
    }
}
