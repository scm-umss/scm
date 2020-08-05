<?php

namespace App\Http\Controllers;

use App\Horario;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Http\Request;
use Monolog\Handler\PushoverHandler;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // $horarios = Horario::all();
        //dd(Carbon::getDays());
        // Carbon::create(Carbon::getDays()[$dia])->locale('es_BO')->dayName
        // $dias = [
        //     0 => 'Domingo',
        //     1 => 'Lunes',
        //     2 => 'Martes',
        //     3 => 'Miércoles',
        //     4 => 'Jueves',
        //     5 => 'Viernes',
        //     6 => 'Sábado',
        // ];
        $dias = Carbon::getDays();

        $tm_hora_inicio = Carbon::createFromTimeString('07:00:00');
        $tm_hora_fin = Carbon::createFromTimeString('12:00:00');
        $tt_hora_inicio = Carbon::createFromTimeString('14:00:00');
        $tt_hora_fin = Carbon::createFromTimeString('18:00:00');

        $horario_tm [] = $tm_hora_inicio->format('H:i');
        while ($tm_hora_inicio < $tm_hora_fin) {
            $horario_tm[] = $tm_hora_inicio->addMinutes(30)->format('H:i');
        }

        $horario_tt [] = $tt_hora_inicio->format('H:i');
        while ($tt_hora_inicio < $tt_hora_fin) {
            $horario_tt[] = $tt_hora_inicio->addMinutes(30)->format('H:i');
        }
        // dd($horario_tm);
        // $horarios = collect();
        // for($i=0; $i<7; $i++){
        //     $horarios->push(new Horario());
        // }

        $sucursales = Sucursal::all();

        $especialidades = Especialidad::find(auth()->user()->especialidadesId());
        // auth()->user()->especialidades();
        //dd($especialidades);
        //$u_especialidad = User::find(1)->with('')

        //dd(auth()->user()->especialidadesMedico());
        // $horarios = Horario::all();
        return view('horarios.edit', compact('dias', 'horario_tm', 'horario_tt', 'sucursales', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        
        $activo = $request->input('activo');
        $tm_hora_inicio = $request->input('tm_hora_inicio');
        $tm_hora_fin = $request->input('tm_hora_fin');
        $tm_sucursal = $request->input('tm_sucursal');
        $tt_hora_inicio = $request->input('tt_hora_inicio');
        $tt_hora_fin = $request->input('tt_hora_fin');
        $tt_sucursal = $request->input('tt_sucursal');
        $user_id = auth()->user()->id;
        $dia= $request->input('dia');

        if(in_array('0', $tm_sucursal) or in_array('0', $tt_sucursal))
            return back()->with('error', 'Debe seleccionar un sucursal');

        for ($i=0; $i < 7; $i++) {
            Horario::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'dia' => $i,
                ],[
                    'activo' => in_array($i, $activo),
                    'tm_hora_inicio' => $tm_hora_inicio[$i],
                    'tm_hora_fin' => $tm_hora_fin[$i],
                    'tm_sucursal' => $tm_sucursal[$i],
                    'tt_hora_inicio' => $tt_hora_inicio[$i],
                    'tt_hora_fin' => $tt_hora_fin[$i],
                    'tt_sucursal' => $tt_sucursal[$i],
                ]
            );
        }

        return back()->with('status', 'Horario Actualizado exitosamente!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horario $horario)
    {
        //
    }
}
