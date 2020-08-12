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
                        <h5 class="card-title">Cita del paciente: {{ $cita->paciente->nombre }} {{ $cita->paciente->ap_paterno }} {{ $cita->paciente->ap_materno }}</h5>
                        <hr>
                        <p class="card-text">Fecha y hora: {{ $cita->fecha_hora }} </p>
                        <p class="card-text">Estado: {{ $cita->estado }}</p>
                        <p class="card-text">Medico: {{ $cita->medico->nombre }}</p>
                        <p class="card-text">Especialidad: {{ $cita->especialidad->nombre }}</p>
                        <p class="card-text">Numero de ficha: {{ $cita->numero_ficha }}</p>

                        <p class="card-text"><small class="text-muted">registrado en: {{ $cita->created_at }}</small></p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
