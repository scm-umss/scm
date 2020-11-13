<?php

namespace App\Http\Controllers;

use App\Support\Collection;
use App\User;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles','especialidades')->get();
        $medicos = new Collection();
        foreach($users as $user){
            if($user->tieneRol(['medico'])){
                $medicos->push((object)$user);
            }
        }
        $medicos = $medicos->paginate(5);
        return view('medicos.index', compact('medicos'));
    }
}
