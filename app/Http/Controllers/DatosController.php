<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Cita;
use App\User;
use App\Horario;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return response()->json($especialidades);
        }else{
            return 'Acceso denegado';
        }
    }

    public function getMedicosJson(Request $request, Especialidad $especialidad){
        if($request->ajax()){
            return $especialidad->users()
                                ->get(['users.id','nombre','ap_paterno','ap_materno']);

        }else{
            return "Acceso denegado";
        }
    }

    public function horasMedico(Request $request){
        $medico = $request->id;
        $fecha = new Carbon($request->fecha);
        $dia = ($fecha->dayOfWeek+6)%7;
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
    public function pacientes(Request $request){
        if($request->get('fecha_inicio')) {
            $pacientesMes = DB::table('users')
                        ->select(DB::raw('count(*) as cantidad, YEAR(created_at) as anio, MONTH(created_at) as mes'))
                        ->whereDate('created_at','>=', $request->get('fecha_inicio'))
                        ->whereDate('created_at','<=', $request->get('fecha_fin'))
                        ->groupBy('anio','mes')
                        ->orderBy('anio','asc')
                        ->orderBy('mes','asc')
                        ->get();
            return($pacientesMes);
        } else {
            return view('reportes.pacientes');
        }
    }
}
