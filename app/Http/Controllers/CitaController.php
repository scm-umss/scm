<?php

namespace App\Http\Controllers;

use App\Cita;
use App\CitaHistorial;
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
        return redirect()->action('CitaController@pendientes');
    }
    public function pendientes(){
        $rol = auth()->user()->roles[0]->slug;
        if($rol == 'admin'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);

        }elseif($rol == 'medico'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->where('medico_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);

        }elseif($rol == 'paciente'){
            $citas_pendientes = Cita::where('estado', 'Reservada')
                                ->where('paciente_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->paginate(10);
        }
        return view('citas.tablas.pendiente', compact('citas_pendientes','rol'));
    }
    public function confirmadas(){
        $rol = auth()->user()->roles[0]->slug;
        $fecha_actual = Carbon::now()->format('Y-m-d');

        if($rol == 'admin'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }elseif($rol == 'medico'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('medico_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }elseif($rol == 'paciente'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('paciente_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }

        return view('citas.tablas.confirmada', compact('citas_confirmadas','rol','fecha_actual'));
    }
    public function historial(){
        $rol = auth()->user()->roles[0]->slug;

        if($rol == 'admin'){
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                                ->orderBy('fecha_programada','DESC')
                                ->orderBy('hora_programada','DESC')
                                ->paginate(10);
        }elseif($rol == 'medico'){
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                            ->where('medico_id', auth()->id())
                            ->orderBy('fecha_programada','DESC')
                            ->orderBy('hora_programada','DESC')
                            ->paginate(10);
        }elseif($rol == 'paciente'){
            $historial_citas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])
                            ->where('paciente_id', auth()->id())
                            ->orderBy('fecha_programada','DESC')
                            ->orderBy('hora_programada','DESC')
                            ->paginate(10);
        }
        return view('citas.tablas.historial', compact('historial_citas','rol'));
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
        $fecha = new Carbon($request->get('fecha_programada'));
        /** La hora ya esta ocupado por otro paciente  */
        $citaRegistrada = Cita::where('fecha_programada', $fecha->format('Y-m-d'))
                        ->where('medico_id', $request->get('medico'))
                        ->where('hora_programada', $request->get('hora_programada'))
                        ->count();
        /** El paciente ya tiene cita registrada para el dia */
        $tieneCita = Cita::where('fecha_programada', $fecha->format('Y-m-d'))
                        ->where('paciente_id', $request->get('paciente'))
                        ->count();

        if(!$tieneCita && !$citaRegistrada){
            $cita = new Cita();
            $cita->paciente_id = $request->get('paciente');
            $cita->medico_id = $request->get('medico');
            $cita->especialidad_id = $request->get('especialidad');
            $cita->sucursal_id = $request->get('sucursal');
            $cita->fecha_programada = $fecha->format('Y-m-d');
            $cita->hora_programada = $request->get('hora_programada');
            // $cita->numero_ficha = $ficha+1;
            $cita->save();
            $cita->citaHistorials()->create([
                'cita_id' => $cita->id,
                'user_id' => auth()->user()->id,
                'evento' => 'Creado'
            ]);
            return 'Cita registrada exitosamente!';
        }else{
            // return 'Ya tiene cita en el día';
            if ($tieneCita) {
                $error = [
                    'error' => 'Usted ya tiene una cita, para la fecha seleccionada.'
                ];
                return response()->json($error);
            }elseif($citaRegistrada){
                $error = [
                    'error' => 'La hora seleccionada ya fue ocupado por otro paciente.'
                ];
                return response()->json($error);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $cita)
    {
        $hCancelado = CitaHistorial::where('evento', 'Cancelado')
                                    ->where('cita_id', $cita->id)
                                    ->first();

        $rol = auth()->user()->roles[0]->slug;
        $fecha_actual = Carbon::now()->format('Y-m-d');

        $this->authorize('view', $cita);
        return view('citas.show', compact('cita','hCancelado','rol','fecha_actual'));
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
        // dd($cita);
        if($request->ajax()){
            // $data = [];
            return response()->json($cita);
        }else{
            return view('admin.citas.edit',compact('cita'));
        }

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
    public function postCancelar(Request $request, Cita $cita){
        if($request->ajax()){
            if(!$request->descripcion){
                return 'Debe completar el campo';
            }
            $cita->estado = 'Cancelada';
            $cita->save();
            $cita->citaHistorials()->create([
                'cita_id' => $cita->id,
                'user_id' => auth()->user()->id,
                'evento' => 'Cancelado',
                'descripcion' => $request->descripcion
            ]);
            return 'Cita cancelada!.';
        }else{
            return "Acceso denegado";
        }

        // return redirect('citas');
    }
    // admin o medico
    public function postConfirmar(Cita $cita){
        $cita->estado = 'Confirmada';
        $cita->save();
        $cita->citaHistorials()->create([
            'cita_id' => $cita->id,
            'user_id' => auth()->user()->id,
            'evento' => 'Confirmado'
        ]);
        return back();
    }
    // admin o medico
    public function postAtendido(Cita $cita){
        $cita->estado = 'Atendida';
        $cita->save();
        $cita->citaHistorials()->create([
            'cita_id' => $cita->id,
            'user_id' => auth()->user()->id,
            'evento' => 'Atendido'
        ]);
        return back();
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
