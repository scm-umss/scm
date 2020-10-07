@extends('layouts.app')

@section('content')
<div class="container ">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">
                <div class="jumbotron">
                    <div class="container">
                        <h1 class="display-4">Detalle de citas</h1>
                        <p class="lead">Informe detallada de la cita #{{ $cita->id }}.</p>
                    </div>
                </div>
                <div class="px-5">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Cita del paciente:</strong> {{ $cita->paciente->nombreCompleto }}</h5>
                        <hr>
                        <p class="card-text"><strong>Fecha:</strong> {{ $cita->fecha_programada }} </p>
                        <p class="card-text"><strong>Hora:</strong> {{ $cita->hora_programada }} </p>
                        <p class="card-text"><strong>Estado:</strong>
                            @if($cita->estado == 'Cancelada')
                                <span class="badge badge-danger">{{ $cita->estado }}</span>
                            @elseif($cita->estado == 'Atendida')
                                <span class="badge badge-success">{{ $cita->estado }}</span>
                            @else
                                <span class="badge badge-warning">{{ $cita->estado }}</span>
                            @endif
                        </p>
                        <p class="card-text"><strong>Medico:</strong> {{ $cita->medico->nombreCompleto }}</p>
                        <p class="card-text"><strong>Especialidad:</strong> {{ $cita->especialidad->nombre }}</p>
                        <p class="card-text"><strong>Numero de ficha:</strong> {{ $cita->numero_ficha }}</p>
                        <p class="card-text"><strong>Sucursal:</strong> {{ $cita->sucursal->nombre }}</p>
                        @if ($cita->estado == 'Cancelada')
                        <div class="alert alert-warning">
                            <h5><strong>Acerca de la cancelación</strong></h5>
                            <hr>
                            <p><strong>Fecha de cancelación:</strong> XXX</p>
                            <p><strong>Cancelado por:</strong> XXX</p>
                            <p><strong>Justificación:</strong> XXX</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mb-4 text-center">
                    <a href="{{ route('citas.index') }}" class="btn btn-danger">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
