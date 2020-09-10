<?php

namespace App\Http\Controllers;

use App\Cita;
use App\User;
use App\Especialidad;
use App\Horario;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        //
        $citas = Cita::all();
        return view('citas.index', compact('citas'));
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
            return view('admin.citas.create', compact('especialidades'));
        }
        return view('citas.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
    public function edit(Cita $cita)
    {
        //
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
        //
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

    public function horario(User $medico){

        $horarios = $medico->horarios;
        return view('citas.horario', compact('horarios','medico'));
    }

    public function horasMedico(Request $request){
        // $fecha = $request->fecha;
        // $medico = $request->id;
        // $medico = User::where('id', 2)->get(['id','nombre','ap_paterno','ap_materno']);
        $f_carbon = new Carbon($request->fecha);
        $dia = $f_carbon->dayOfWeek;
        // dd($f_carbon->dayOfWeek);
        // $medico = User::findOrFail($request->id);
        // $tm_horario = $medico->horarios()->where('tm_activo',1)->where('dia',1)->get();
        $tm_horario = Horario::where('tm_activo',true)
                                ->where('dia',$dia)
                                ->where('user_id', $request->id)
                                ->first([
                                    'tm_hora_inicio', 'tm_hora_fin'
                                ]);
        $tt_horario = Horario::where('tt_activo',true)
                                ->where('dia',$dia)
                                ->where('user_id', $request->id)
                                ->first([
                                    'tt_hora_inicio', 'tt_hora_fin'
                                ]);
        $tm_intervalos = [];
        $tt_intervalos = [];

        if (!$tm_horario && !$tt_horario) {
            return [];
        }elseif (!$tm_horario) {
            $tt_intervalos = $this->getIntervalos($tt_horario->tt_hora_inicio, $tt_horario->tt_hora_fin);
        }elseif(!$tt_horario){
             $tm_intervalos = $this->getIntervalos($tm_horario->tm_hora_inicio, $tm_horario->tm_hora_fin);
        }else{
             $tm_intervalos = $this->getIntervalos($tm_horario->tm_hora_inicio, $tm_horario->tm_hora_fin);
             $tt_intervalos = $this->getIntervalos($tt_horario->tt_hora_inicio, $tt_horario->tt_hora_fin);
        }
        // dd($tm_intervalos);
        $data =[
            // 'fecha' => $fecha,
            // 'medico' => $medico,
            'tm_horario' => $tm_intervalos,
            'tt_horario' => $tt_intervalos
        ];
        return response()->json($data);


    }

    private function getIntervalos($inicio, $fin){
        $inicio = new Carbon($inicio);
        $fin = new Carbon($fin);
        $intervalos=[];
        while ($inicio < $fin) {
            $intervalo = [];

            $intervalo['inicio'] = $inicio->format('H:i');
            $inicio->addMinutes(30);
            $intervalo['fin'] = $inicio->format('H:i');

            $intervalos[]=$intervalo;
        }
        // dd($intervals);
        return $intervalos;
    }
}
