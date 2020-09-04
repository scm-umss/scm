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
        //
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

    public function medicos(Especialidad $especialidad){
        $medicos = $especialidad->users;
        return view('citas.medicos', compact('medicos','especialidad'));
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
        $tt_horario = Horario::where('tm_activo',true)
                                ->where('dia',$dia)
                                ->where('user_id', $request->id)
                                ->first([
                                    'tt_hora_inicio', 'tt_hora_fin'
                                ]);

        // return $request->all();
        // dd($tm_horario->tm_hora_inicio);
        $data =[
            // 'fecha' => $fecha,
            // 'medico' => $medico,
            'tm_horario' => $tm_horario,
            'tt_horario' => $tt_horario
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
