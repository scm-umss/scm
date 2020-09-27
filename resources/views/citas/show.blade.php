@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">
                <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="..." class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div></div>
                        <h5 class="card-title">Cita del paciente: {{ $cita->paciente->nombreCompleto }}</h5>
                        <hr>
                        <p class="card-text">Fecha: {{ $cita->fecha_programada }} </p>
                        <p class="card-text">Hora: {{ $cita->hora_programada }} </p>
                        <p class="card-text">Estado: {{ $cita->estado }}</p>
                        <p class="card-text">Medico: {{ $cita->medico->nombre }}</p>
                        <p class="card-text">Especialidad: {{ $cita->especialidad->nombre }}</p>
                        <p class="card-text">Numero de ficha: {{ $cita->numero_ficha }}</p>
                        <p class="card-text">Sucursal: {{ $cita->sucursal->nombre }}</p>

                        <p class="card-text"><small class="text-muted">registrado en: {{ $cita->created_at }}</small></p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
