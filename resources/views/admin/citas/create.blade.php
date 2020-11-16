@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h4>Estás agendando cita a: <span class="badge badge-secondary">{{ $paciente->nombreCompleto }}</span></h4>
                    <div class="">
                        <a class="btn btn-outline-danger" href="{{ url()->previous() }}"><i class="fas fa-arrow-circle-left"></i> Cancelar</a>
                    </div>
                </div>

                <div class="card-body">
                    <crear-cita paciente-id="{{ $paciente->id }}"></crear-cita>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
