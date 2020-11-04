<?php

namespace App\Http\Controllers;

use App\Cita;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function pacientes(){
        $hoy = Carbon::now();
    	$end = $hoy->endOfDay()->format('Y-m-d');
        $start = $hoy->startOfDay()->subYear()->format('Y-m-d');

        $f_ini = $start;
        $f_fin = $end;
        if (request()->get('fecha_inicio')) {
            $mes_inicio = '01-'.request()->get('fecha_inicio');
            $mes_fin = '01-'.request()->get('fecha_fin');
            $f_ini = (new Carbon($mes_inicio))->startOfMonth()->format('Y-m-d');
            $f_fin = (new Carbon($mes_fin))->endOfMonth()->format('Y-m-d');
        }

        if ($f_ini != $end) {
            $start= $f_ini;
            $end = $f_fin;
        }


        if (request()->ajax()) {
            // dd($start);
            $pacientesMes = (User::query()->selectRaw('COUNT(*) as cantidad, MONTH(created_at) as mes, YEAR(created_at) as anio')
                                    ->where('created_at','>=', $start)
                                    ->where('created_at','<=', $end)
                                    ->whereExists(function($query){
                                        $query->select(DB::raw(1))
                                        ->from('rol_user')
                                        ->whereRaw('rol_user.user_id = users.id and rol_user.rol_id = 3');
                                    })
                                    ->groupBy('mes','anio')
                                    ->orderBy('anio','asc')
                                    ->orderBy('mes','asc')
                                    ->get()
                            );

            $data=[];
            $categoria = [];
            $cantidad = [];
            foreach($pacientesMes as $paciente){
                $mes = str_pad($paciente['mes'],2,"0",STR_PAD_LEFT);
                $categoria[] = $paciente['anio'].'-'.$mes;
                $cantidad[]=$paciente['cantidad'];

            }
            // dd($pacientesMes->toArray());
            // return view('reportes.pacientes',compact('data'));

            $data['categoria']=$categoria;
            $data['cantidad']=$cantidad;
            return $data;
        }else{
            return view('reportes.pacientes');
        }
    }
    public function estadoCitas(){
        $hoy = Carbon::now();
    	$start = $hoy->format('Y-m-d');
        $end = $hoy->addMonth()->format('Y-m-d');


        $f_ini = $start;
        $f_fin = $end;
        // dd(request()->get('fecha_inicio'));
        if (request()->get('fecha_inicio')) {
            $mes_inicio = request()->get('fecha_inicio');
            $mes_fin = request()->get('fecha_fin');
            $f_ini = (new Carbon($mes_inicio))->format('Y-m-d');
            $f_fin = (new Carbon($mes_fin))->format('Y-m-d');
        }

        if ($f_ini != $end) {
            $start= $f_ini;
            $end = $f_fin;
        }


        if (request()->ajax()) {
            // dd($start);
            $estadoCitas = (Cita::query()->selectRaw('COUNT(*) as y, estado as name')
                                    ->where('fecha_programada','>=', '2019-01-01')
                                    // ->where('created_at','<=', $end)
                                    ->groupBy('name')
                                    ->orderBy('y','desc')
                                    ->get()
                            );

            $data=[];
            // $categoria = [];
            $cantidad = [];
            $aux = collect();
            foreach($estadoCitas as $estado){
                $aux->push($estado);

            }
            $data['cantidad']=$aux;
            return $data;
        }else{


            return view('reportes.estadocitas');
        }
    }
}
