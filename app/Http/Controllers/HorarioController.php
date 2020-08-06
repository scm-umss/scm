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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $horarios_medico = Horario::where('user_id', auth()->user()->id)->get();

        $dias = Carbon::getDays();


        // dd($horario_medico->toArray());
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

        // $dias_tt = Carbon::getDays();

        $tm_hora_inicio = Carbon::createFromTimeString('07:00:00');
        $tm_hora_fin = Carbon::createFromTimeString('12:00:00');
        $tt_hora_inicio = Carbon::createFromTimeString('14:00:00');
        $tt_hora_fin = Carbon::createFromTimeString('18:00:00');


        if(count($horarios_medico) > 0){
            $horario_tm [] = $tm_hora_inicio->format('H:i');
            while ($tm_hora_inicio < $tm_hora_fin) {
                $horario_tm[] = $tm_hora_inicio->addMinutes(30)->format('H:i');
            }

            $horario_tt [] = $tt_hora_inicio->format('H:i');
            while ($tt_hora_inicio < $tt_hora_fin) {
                $horario_tt[] = $tt_hora_inicio->addMinutes(30)->format('H:i');
            }
        }else{
            $horarios_medico = collect();
            for ($i=0; $i < 7; $i++) {
                $horarios_medico->push(new Horario());
            }
            $horario_tm [] = $tm_hora_inicio->format('H:i');
            while ($tm_hora_inicio < $tm_hora_fin) {
                $horario_tm[] = $tm_hora_inicio->addMinutes(30)->format('H:i');
            }

            $horario_tt [] = $tt_hora_inicio->format('H:i');
            while ($tt_hora_inicio < $tt_hora_fin) {
                $horario_tt[] = $tt_hora_inicio->addMinutes(30)->format('H:i');
            }
        }


        $sucursales = Sucursal::all();

        $especialidades = Especialidad::find(auth()->user()->especialidadesId());

        return view('horarios.edit', compact('dias', 'horario_tm', 'horario_tt', 'sucursales', 'especialidades', 'horarios_medico'));
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

        $tm_activo = $request->input('tm_activo') ? : [];
        $tm_hora_inicio = $request->input('tm_hora_inicio');
        $tm_hora_fin = $request->input('tm_hora_fin');
        $tm_sucursal = $request->input('tm_sucursal');
        $tm_especialidad = $request->input('tm_especialidad');

        $tt_activo = $request->input('tt_activo') ? : [];
        $tt_hora_inicio = $request->input('tt_hora_inicio');
        $tt_hora_fin = $request->input('tt_hora_fin');
        $tt_sucursal = $request->input('tt_sucursal');
        $tt_especialidad = $request->input('tt_especialidad');
        // $dia_tm = $request->input('dia_tm');
        // $dia_tt = $request->input('dia_tt');

        $user_id = auth()->user()->id;
        // $dia= $request->input('dia');


        // dd($request->all());
        // for ($i=0; $i < 7; $i++) {
        //     if(in_array($i, $activo)){
        //         if($tm_sucursal[$i] != '0' or $tm_sucursal[$i] != '0'){
        //             Horario::updateOrCreate(
        //                 [
        //                     'user_id' => $user_id,
        //                     'dia' => $i,
        //                 ],[
        //                     'activo' => in_array($i, $activo),
        //                     'tm_hora_inicio' => $tm_hora_inicio[$i],
        //                     'tm_hora_fin' => $tm_hora_fin[$i],
        //                     'tm_sucursal' => $tm_sucursal[$i],
        //                     'tt_hora_inicio' => $tt_hora_inicio[$i],
        //                     'tt_hora_fin' => $tt_hora_fin[$i],
        //                     'tt_sucursal' => $tt_sucursal[$i],
        //                 ]
        //             );
        //         }
        //         else{
        //             return back()->with('error', 'Debe seleccionar un sucursal');
        //         }
        //     }
        // }

        // if(in_array('0', $tm_sucursal) or in_array('0', $tt_sucursal))
        //  return back()->with('error', 'Debe seleccionar un sucursal');
        for ($i=0; $i < 7; $i++) {
            Horario::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'dia' => $i,
                ],[
                    'tm_activo' => in_array($i, $tm_activo),
                    'tm_hora_inicio' => $tm_hora_inicio[$i],
                    'tm_hora_fin' => $tm_hora_fin[$i],
                    'tm_sucursal' => $tm_sucursal[$i],
                    'tm_especialidad' => $tm_especialidad[$i],
                    'tt_activo' => in_array($i, $tt_activo),
                    'tt_hora_inicio' => $tt_hora_inicio[$i],
                    'tt_hora_fin' => $tt_hora_fin[$i],
                    'tt_sucursal' => $tt_sucursal[$i],
                    'tt_especialidad' => $tt_especialidad[$i],
                ]
            );
        }

        return back()->with('status', 'Horario Actualizado exitosamente!.');
    }
}
