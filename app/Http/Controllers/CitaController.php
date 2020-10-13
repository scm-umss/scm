<?php

namespace App\Http\Controllers;

use App\Cita;
use App\User;
use App\Horario;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Http\Request;
use App\Http\Requests\CitaRequest;
use App\Sucursal;
use Illuminate\Support\Facades\Date;

class CitaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rol = auth()->user()->roles[0]->slug;
        // dd($rol);
        if($rol == 'admin'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
            // $citas_atendidas = Cita::where('estado', 'Atendida')->paginate(10);
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                                ->orderBy('fecha_programada','DESC')
                                ->orderBy('hora_programada','DESC')
                                ->paginate(10);
        }elseif($rol == 'medico'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->where('medico_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('medico_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                            ->where('medico_id', auth()->id())
                            ->orderBy('fecha_programada','DESC')
                            ->orderBy('hora_programada','DESC')
                            ->paginate(10);
        }elseif($rol == 'paciente'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->where('paciente_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->paginate(10);
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('paciente_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                            ->where('paciente_id', auth()->id())
                            ->orderBy('fecha_programada','DESC')
                            ->orderBy('hora_programada','DESC')
                            ->paginate(10);
            // return view('citas.index', compact('citas_pendientes','citas_confirmadas','historial_citas','rol'));
        }
        return view('citas.index', compact('citas_pendientes','citas_confirmadas','historial_citas','rol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialidades = Especialidad::all();
        if (auth()->user()->isSuperAdmin()) {

            $pacientes = User::all()->reject(function($user) {
                return !$user->tieneRol(['paciente']);
            })->paginate(5);
            return view('pacientes.index', compact('pacientes'));
        }
        return view('citas.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CitaRequest $request)
    {
        // dd($request);
        $fecha = new Carbon($request->get('fecha_programada'));
        // dump($fecha->format('Y-m-d'));
        $ficha = 1;
        /** La hora ya esta ocupado por otro paciente  */
        $citaRegistrada = Cita::where('fecha_programada', $fecha->format('Y-m-d'))
                        ->where('medico_id', $request->get('medico'))
                        ->where('hora_programada', $request->get('hora_programada'))
                        ->count();
        /** El paciente ya tiene cita registrada para el dia */
        $tieneCita = Cita::where('fecha_programada', $fecha->format('Y-m-d'))
                        ->where('paciente_id', $request->get('paciente'))
                        ->count();
        // dd($tieneCita);
        if(!$tieneCita && !$citaRegistrada){
            $cita = new Cita();
            $cita->paciente_id = $request->get('paciente');
            $cita->medico_id = $request->get('medico');
            $cita->especialidad_id = $request->get('especialidad');
            $cita->sucursal_id = $request->get('sucursal');
            $cita->fecha_programada = $fecha->format('Y-m-d');
            $cita->hora_programada = $request->get('hora_programada');
            $cita->numero_ficha = $ficha+1;
            $cita->save();
            $cita->citaHistorials()->create([
                'cita_id' => $cita->id,
                'user_id' => auth()->user()->id,
                'evento' => 'Creado'
            ]);
            return 'Cita registrada exitosamente!';
        }else{
            // return 'Ya tiene cita en el día';
            $error = [
                'error' => 'Algo anda mal, creo que ya existe cita con el médico...'
            ];
            return response()->json($error);
        }

        // return redirect()->route('citas.index')->with('status','Registro realizado exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $cita)
    {
        $this->authorize('view', $cita);
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cita $cita)
    {
        $this->authorize('update', $cita);
        $espcialidad = Especialidad::where('id',$cita->especialidad_id)->first(['id','nombre']);
        $medico = User::where('id',$cita->medico_id)->first(['id','nombre']);
        $sucursal = Sucursal::where('id',$cita->sucursal_id)->first(['id','nombre']);
        // dd($cita);
        // dd($cita);
        if($request->ajax()){
            // $data = [];
            return response()->json($cita);
        }else{
            return view('admin.citas.edit',compact('cita'));
        }

        // $especialidades = Especialidad::all();
        // return view('admin.citas.edit', compact('cita','especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cita $cita)
    {
        $this->authorize('update', $cita);
        $fecha = (new Carbon($request['params']['fecha_programada']))->format('Y-m-d');
        // dd($fecha);
        $cita->paciente_id = $request['params']['paciente'];
        $cita->medico_id = $request['params']['medico'];
        $cita->especialidad_id = $request['params']['especialidad'];
        $cita->sucursal_id = $request['params']['sucursal'];
        $cita->fecha_programada = $fecha;
        $cita->hora_programada = $request['params']['hora_programada'];
        $cita->save();
        $cita->citaHistorials()->create([
            'cita_id' => $cita->id,
            'user_id' => auth()->user()->id,
            'evento' => 'Modificado'
        ]);
        return "Cita actualizada exitosamente.";
    }
    // todos
    public function postCancelar(Cita $cita){
        // dd($cita);
        $cita->estado = 'Cancelada';
        $cita->save();
        $cita->citaHistorials()->create([
            'cita_id' => $cita->id,
            'user_id' => auth()->user()->id,
            'evento' => 'Cancelado'
        ]);
        return redirect('citas');
    }
    // admin o medico
    public function postConfirmar(Cita $cita){
        // dd($cita);
        $cita->estado = 'Confirmada';
        $cita->save();
        $cita->citaHistorials()->create([
            'cita_id' => $cita->id,
            'user_id' => auth()->user()->id,
            'evento' => 'Confirmado'
        ]);
        return redirect('citas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cita $cita)
    {
        //
    }
    // solo admin
    public function agendarCita(User $paciente){
        $this->authorize('create', Cita::class);
        return view('admin.citas.create', compact('paciente'));
    }

    // paciente
    public function getMedicos(Request $request, Especialidad $especialidad){
        $medicos = $especialidad->users;
        return view('citas.medicos', compact('medicos','especialidad'));
    }
    /** Solo para mostrar al paciente */
    public function horario(User $medico, Especialidad $especialidad){

        $horarios = $medico->horarios;
        return view('citas.horario', compact('horarios','medico','especialidad'));
    }
}
