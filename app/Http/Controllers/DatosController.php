<?php

namespace App\Http\Controllers;

use App\Cita;
use App\Horario;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Http\Request;

class DatosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
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

    public function getMedicosJson(Request $request, Especialidad $especialidad){
        if($request->ajax()){
            return $especialidad->users()->get(['users.id','nombre','ap_paterno','ap_materno']);
        }else{
            return "Acceso denegado";
        }
    }

    public function horasMedico(Request $request){
        // $fecha = $request->fecha;
        // dd($request->especialidad);
        $medico = $request->id;
        // $medico = User::where('id', 2)->get(['id','nombre','ap_paterno','ap_materno']);
        $fecha = new Carbon($request->fecha);
        // for ($i=0; $i <7 ; $i++) {
        //     if($i == 0){

        //     }
        // }
        $dia = ($fecha->dayOfWeek+6)%7;
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
    private function estaDisponible($fecha, $medico, $inicio){
        $existe = Cita::where('medico_id', $medico)
                    ->where('fecha_programada', $fecha
                    ->format('Y-m-d'))
                    ->where('hora_programada',$inicio)
                    ->exists();
        // Estará disponible cuando no exista cita reservada para esa fecha y hora con el medico
        return !$existe;
    }
}
