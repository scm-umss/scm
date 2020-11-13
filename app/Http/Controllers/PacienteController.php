<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PacienteController extends Controller
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
        $pacientes = User::all()->reject(function($user) {
            return !$user->tieneRol(['paciente']);
        })->paginate(5);

        return view('pacientes.index', compact('pacientes'));
    }
}
