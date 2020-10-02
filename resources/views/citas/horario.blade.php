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
                        {{-- <h6>Estás reservando cita con el</h6> --}}
                        <p class="card-text">Estás reservando cita con el <strong>Médico</strong> {{ $medico->nombreCompleto }} de la <strong>Especialidad</strong> {{ $especialidad->nombre }}</p>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <h5 class="card-title font-weight-bold">Horas disponible</h5>

                            <a class="btn btn-danger" href="{{ route('citas.medicos', $medico->id) }}" role="button"><svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>Volver</a>

                    </div>
                        <hr>
                        {{-- <input type="date" data-provide="datepicker" class="datepicker form-control" id="fecha"> --}}
                        <cita-paciente medico-id="{{ $medico->id }}" especialidad-id="{{ $especialidad->id }}" paciente-id="{{ auth()->user()->id }}"></cita-paciente>
                        {{-- <fecha-component medico-id="{{ $medico->id }}"></fecha-component> --}}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
