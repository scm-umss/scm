@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Estás editando la cita de: <span class="badge badge-secondary">{{ $cita->paciente->nombreCompleto }}</span></h4>
                </div>

                <div class="card-body">
                    <editar-cita cita-id="{{ $cita->id }}"></editar-cita>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
