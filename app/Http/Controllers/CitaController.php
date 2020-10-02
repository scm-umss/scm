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
            $citas_pendientes = Cita::where('estado', 'Reservada')->paginate(10);
            $citas_confirmadas = Cita::where('estado', 'Reservada')->paginate(10);
            // $citas_atendidas = Cita::where('estado', 'Atendida')->paginate(10);
            $citas_pasadas = Cita::whereIn('estado', ['Atendida', 'Cancelada'])->paginate(10);
            return view('citas.index', compact('citas_pendientes','citas_confirmadas','citas_pasadas'));
        }elseif($rol == 'medico'){
            return 'vista para medico';
        }elseif($rol == 'paciente'){
            return 'vista para paciente';
        }
        // $citas = Cita::all();
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
        //
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
        // dd($request['params']['fecha_programada']);
        // $fecha = $request['params']['fecha_programada'];
        // $fecha_p = Carbon::createFromFormat('Y-m-d', $fecha);
        $fecha = (new Carbon($request['params']['fecha_programada']))->format('Y-m-d');
        // dd($fecha);
        $cita->paciente_id = $request['params']['paciente'];
        $cita->medico_id = $request['params']['medico'];
        $cita->especialidad_id = $request['params']['especialidad'];
        $cita->sucursal_id = $request['params']['sucursal'];
        $cita->fecha_programada = $fecha;
        $cita->hora_programada = $request['params']['hora_programada'];
        $cita->save();
        return "Cita actualizada exitosamente.";
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
    public function agendarCita(User $paciente){
        return view('admin.citas.create', compact('paciente'));
    }

    /** Para gestion Admin */
    public function getEspecialidades(Request $request){
        if($request->ajax()){
            $especialidades = Especialidad::get(['id','nombre']);
            // $especialidades = Especialidad::get('nombre','id');
            return response()->json($especialidades);
        }else{
            return 'Acceso denegado';
        }
    }

    public function getMedicos(Request $request, Especialidad $especialidad){
        if($request->ajax()){
            return $especialidad->users()->get(['users.id','nombre','ap_paterno','ap_materno']);
        }else{
            $medicos = $especialidad->users;
            return view('citas.medicos', compact('medicos','especialidad'));
        }
    }
    /** Solo para mostrar al paciente */
    public function horario(User $medico, Especialidad $especialidad){

        $horarios = $medico->horarios;
        return view('citas.horario', compact('horarios','medico','especialidad'));
    }

    public function horasMedico(Request $request){
        // $fecha = $request->fecha;
        // dd($request->especialidad);
        $medico = $request->id;
        // $medico = User::where('id', 2)->get(['id','nombre','ap_paterno','ap_materno']);
        $fecha = new Carbon($request->fecha);
        $dia = $fecha->dayOfWeek;
        // dd($f_carbon->dayOfWeek);
        // $medico = User::findOrFail($request->id);
        // $tm_horario = $medico->horarios()->where('tm_activo',1)->where('dia',1)->get();
        $tm_horario = Horario::where('tm_activo',true)
                                ->where('dia',$dia)
                                ->where('user_id', $medico)
                                ->where('tm_especialidad', $request->especialidad)
                                ->first([
                                    'tm_hora_inicio', 'tm_hora_fin', 'tm_sucursal'
                                ]);
        $tt_horario = Horario::where('tt_activo',true)
                                ->where('dia',$dia)
                                ->where('user_id', $medico)
                                ->where('tt_especialidad', $request->especialidad)
                                ->first([
                                    'tt_hora_inicio', 'tt_hora_fin','tt_sucursal'
                                ]);
        // $data = $this->estaDisponible($tm_horario,$tt_horario,$fecha,$medico);
        $tm_intervalos = [];
        $tt_intervalos = [];
        $tm_sucursal = [];
        $tt_sucursal = [];
        if (!$tm_horario && !$tt_horario) {
            $data =[
                'tm_horario' => $tm_intervalos,
                'tm_sucursal' => $tm_sucursal,
                'tt_horario' => $tt_intervalos,
                'tt_sucursal' => $tt_sucursal,
            ];
            return $data;
        }elseif (!$tm_horario) {
            $tt_intervalos = $this->getIntervalos($tt_horario->tt_hora_inicio, $tt_horario->tt_hora_fin, $fecha, $medico);
            $tt_sucursal = Sucursal::where('id',$tt_horario->tt_sucursal)->first(['id','nombre']);
        }elseif(!$tt_horario){
             $tm_intervalos = $this->getIntervalos($tm_horario->tm_hora_inicio, $tm_horario->tm_hora_fin, $fecha, $medico);
             $tm_sucursal = Sucursal::where('id',$tm_horario->tm_sucursal)->first(['id','nombre']);
        }else{
             $tm_intervalos = $this->getIntervalos($tm_horario->tm_hora_inicio, $tm_horario->tm_hora_fin, $fecha, $medico);
             $tt_intervalos = $this->getIntervalos($tt_horario->tt_hora_inicio, $tt_horario->tt_hora_fin, $fecha, $medico);
             $tt_sucursal = Sucursal::where('id',$tt_horario->tt_sucursal)->first(['id','nombre']);
             $tm_sucursal = Sucursal::where('id',$tm_horario->tm_sucursal)->first(['id','nombre']);
        }
        // dd($tm_intervalos);
        // $tm_sucursal1 = $tm_horario->sucursal();


        $data =[
            'tm_horario' => $tm_intervalos,
            'tm_sucursal' => $tm_sucursal,
            'tt_horario' => $tt_intervalos,
            'tt_sucursal' => $tt_sucursal,
        ];

        return response()->json($data);


    }

    private function estaDisponible($fecha, $medico, $inicio){
        $existe = Cita::where('medico_id', $medico)
                    ->where('fecha_programada', $fecha
                    ->format('Y-m-d'))
                    ->where('hora_programada',$inicio)
                    ->exists();
        // Estará disponible cuando no exista cita reservada para esa fecha y hora con el medico
        return !$existe;
    }

    private function getIntervalos($inicio, $fin, $fecha, $medico){
        $inicio = new Carbon($inicio);
        $fin = new Carbon($fin);
        // dd($fecha->format('Y-m-d'));
        $intervalos=[];
        while ($inicio < $fin) {
            $intervalo = [];

            $intervalo['inicio'] = $inicio->format('H:i');

            $disponible = $this->estaDisponible($fecha,$medico,$inicio);


            $inicio->addMinutes(30);
            $intervalo['fin'] = $inicio->format('H:i');
            if($disponible){
                $intervalos[]=$intervalo;
            }
        }
        // dd($intervals);
        return $intervalos;
    }
}
