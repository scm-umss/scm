<?php

namespace App\Http\Controllers;

use App\Cita;
use App\User;
use Carbon\Carbon;
use App\Especialidad;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

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

            $data['categoria']=$categoria;
            $data['cantidad']=$cantidad;
            return $data;
        }else{
            return view('reportes.pacientes', compact('f_ini', 'f_fin'));
        }
    }

    public function estadoCitas(){
        $hoy = Carbon::now();
    	$start = $hoy->format('Y-m-d');
        $end = $hoy->addMonth()->format('Y-m-d');


        $f_ini = $start;
        $f_fin = $end;
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
            $estadoCitas = (Cita::query()->selectRaw('COUNT(*) as y, estado as name')
                                    ->where('fecha_programada','>=', $start)
                                    ->where('fecha_programada','<=', $end)
                                    ->groupBy('name')
                                    ->orderBy('y','desc')
                                    ->get()
                            );

            $data=[];
            $aux = collect();
            foreach($estadoCitas as $estado){
                $aux->push($estado);

            }
            $data['cantidad']=$aux;
            return $data;
        }else{
            return view('reportes.estadocitas', compact('f_ini', 'f_fin'));
        }
    }

    public function especialidadCitas(){
        $hoy = Carbon::now();
    	$end = $hoy->endOfDay()->format('Y-m-d');
        $start = $hoy->startOfDay()->subYear()->format('Y-m-d');

        $f_ini = $start;
        $f_fin = $end;
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
            $especialidadCitas = Especialidad::withTrashed()->select('nombre')
                            ->withCount([
                                'citas',
                                'citas' => function (Builder $query) use ($start, $end) {
                                    $query->where('fecha_programada','>=', $start)
                                    ->where('fecha_programada','<=', $end);
                                }
                            ])
                            ->get();

            $data=[];
            $series = [];
            $data['categorias'] = $especialidadCitas->pluck('nombre');
            // $series['name'] = 'Citas';
            $series['data'] = $especialidadCitas->pluck('citas_count');

            $data['series'] = $series;

            return $data;
        }else{
            return view('reportes.especialidadcitas', compact('f_ini', 'f_fin'));
        }
    }

    public function citasMedico(){
        $hoy = Carbon::now();
    	$end = $hoy->endOfDay()->format('Y-m-d');
        $start = $hoy->startOfDay()->subYear()->format('Y-m-d');

        $f_ini = $start;
        $f_fin = $end;
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
            $citasMedico = (User::query()
                                ->selectRaw('CONCAT(nombre, " ", ap_paterno, " ", ap_materno) AS medico')
                                ->withCount([
                                    'citasAtendidas' => function ($query) use ($start, $end) {
                                        $query->whereBetween('fecha_programada', [$start, $end]);
                                    },
                                    'citasCanceladas' => function ($query) use ($start, $end) {
                                        $query->whereBetween('fecha_programada', [$start, $end]);
                                    },
                                ])
                                ->whereExists(function($query){
                                    $query->select(DB::raw(1))
                                    ->from('rol_user')
                                    ->whereRaw('rol_user.user_id = users.id and rol_user.rol_id = 2');
                                })
                                ->orderBy('citas_atendidas_count','desc')
                                ->take(10)
                                ->get()
                        );

            $data=[];
            $data['categorias'] = $citasMedico->pluck('medico');

            $series = [];
            $series1['name'] = 'Citas antendidas';
            $series1['data'] = $citasMedico->pluck('citas_atendidas_count');
            $series2['name'] = 'Citas canceladas';
            $series2['data'] = $citasMedico->pluck('citas_canceladas_count');
            $series[] = $series1;
            $series[] = $series2;

            $data['series'] = $series;
            return $data;
        }else{
            return view('reportes.citasmedico', compact('f_ini', 'f_fin'));
        }
    }
}
