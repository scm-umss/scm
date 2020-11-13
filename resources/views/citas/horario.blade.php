@extends('layouts.app')

@section('content')
@section('styles')

@endsection
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-3 shadow">
                <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="m-3">
                        <img src="/storage/{{$medico->imagen}}" class="card-img" alt="foto">
                        <p class="card-text">Estás reservando cita con el <strong>Médico</strong> {{ $medico->nombreCompleto }} de la <strong>Especialidad</strong> {{ $especialidad->nombre }}</p>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <h5 class="card-title font-weight-bold">Horas disponible</h5>

                            <a class="btn btn-danger" href="{{ route('citas.medicos', $especialidad->id) }}" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Volver</a>

                    </div>
                        <hr>
                        <cita-paciente medico-id="{{ $medico->id }}" especialidad-id="{{ $especialidad->id }}" paciente-id="{{ auth()->user()->id }}"></cita-paciente>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
