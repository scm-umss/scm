<?php

namespace App\Http\Controllers;

use App\Cita;
use App\Especialidad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rol = auth()->user()->roles[0]->slug;

        $pacientes = User::whereExists(function($query){
                        $query->select(DB::raw(1))
                        ->from('rol_user')
                        ->whereRaw('rol_user.user_id = users.id and rol_user.rol_id = 3');
                    })
                    ->count();
        
        $medicos = User::whereExists(function($query){
                        $query->select(DB::raw(1))
                        ->from('rol_user')
                        ->whereRaw('rol_user.user_id = users.id and rol_user.rol_id = 2');
                    })
                    ->count();
        
        $especialidades = Especialidad::all()->count();
        $citas = Cita::where('estado','Reservada')->count();


        // $rol = auth()->user()->roles[0]->slug;
        
        if($rol == 'admin'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }elseif($rol == 'medico'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('medico_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }elseif($rol == 'paciente'){
            $citas_confirmadas = Cita::where('estado', 'Confirmada')
                                ->where('paciente_id', auth()->id())
                                ->orderBy('fecha_programada','ASC')
                                ->orderBy('hora_programada','ASC')
                                ->paginate(10);
        }


        return view('home', compact('rol','pacientes','medicos','especialidades','citas', 'citas_confirmadas'));
    }
}
