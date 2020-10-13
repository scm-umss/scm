<?php

namespace App\Http\Controllers;

use App\User;
use App\Horario;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Http\Request;
use Monolog\Handler\PushoverHandler;

class HorarioController extends Controller
{
    private $dias = [
        0 => 'Lunes',
        1 => 'Martes',
        2 => 'Miércoles',
        3 => 'Jueves',
        4 => 'Viernes',
        5 => 'Sábado',
        6 => 'Domingo',
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'medico']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $medico)
    {
        // $usuario = User::findOrfail($id);
        $this->authorize('update', $medico);
        // $medico->load('roles');
        $horarios_medico = Horario::where('user_id', $medico->id)->get();
        // dd($horarios_medico);
        $dias = $this->dias;

        if ($medico->tieneRol(['paciente'])) {
            return redirect()->route('usuarios.show',['usuario' => $medico])->with('status','Un paciente no puede registrar su horario.');
        }

        $horario_tm = $this->getHoras('07:00:00', '12:00:00');
        $horario_tt = $this->getHoras('14:00:00', '18:00:00');

        if (count($horarios_medico) < 1) {
            $horarios_medico = collect();
            for ($i = 0; $i < 7; $i++) {
                $horarios_medico->push(new Horario());
            }
        }

        // for ($i=0; $i < 7; $i++) { 
        //     if(!isset($i, $horarios_medico)) {
        //         $horarios_medico[$i] = new Horario();
        //     }
        // }

        //dd($horarios_medico);

        $sucursales = Sucursal::get(['id','nombre']);

        $especialidades = $medico->especialidades()->get(['especialidads.id','especialidads.nombre']);

        return view('horarios.edit', compact('dias', 'medico', 'horario_tm', 'horario_tt', 'sucursales', 'especialidades', 'horarios_medico'));
    }

    private function getHoras($inicio, $fin)
    {
        $hora_inicio = Carbon::createFromTimeString($inicio);
        $hora_fin = Carbon::createFromTimeString($fin);
        $horas[] = $hora_inicio->format('H:i');
        while ($hora_inicio < $hora_fin) {
            $horas[] = $hora_inicio->addMinutes(30)->format('H:i');
        }
        return $horas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->toArray());
        $usuario = User::findOrfail($id);
        $this->authorize('update', $usuario);

        $tm_activo = $request->input('tm_activo') ?: [];
        $tm_hora_inicio = $request->input('tm_hora_inicio');
        $tm_hora_fin = $request->input('tm_hora_fin');
        $tm_sucursal = $request->input('tm_sucursal');
        $tm_especialidad = $request->input('tm_especialidad');

        $tt_activo = $request->input('tt_activo') ?: [];
        $tt_hora_inicio = $request->input('tt_hora_inicio');
        $tt_hora_fin = $request->input('tt_hora_fin');
        $tt_sucursal = $request->input('tt_sucursal');
        $tt_especialidad = $request->input('tt_especialidad');
        // $dia_tm = $request->input('dia_tm');
        // $dia_tt = $request->input('dia_tt');

        // $user_id = auth()->user()->id;
        //dd($request->input());
        $error = [];
        for ($i = 0; $i < 7; $i++) {
            if (in_array($i, $tm_activo)) {

                if ($tm_hora_inicio[$i] >= $tm_hora_fin[$i]) {
                    $error[] = "Horario inconsistente para el día " . $this->dias[$i] . " y turno Mañana";
                }
            }
            if (in_array($i, $tt_activo)) {
                if ($tt_hora_inicio[$i] >= $tt_hora_fin[$i]) {
                    $error[] = "Horario inconsistente para el día " . $this->dias[$i] . " y turno Tarde";
                }
            }
        }
        if (count($error) > 0) {
            return back()->with('error', $error)->withInput($request->input());
        }

        for ($i = 0; $i < 7; $i++) {
            Horario::updateOrCreate(
                [
                    'user_id' => $id,
                    'dia' => $i,
                ],
                [
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
