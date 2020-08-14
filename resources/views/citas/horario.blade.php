@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">

                <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="m-3">
                        <img src="/storage/{{$medico->imagen}}" class="card-img" alt="foto">
                        <p class="card-text">{{ $medico->nombre }} {{ $medico->ap_paterno }} {{ $medico->ap_materno }}</p>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <h5 class="card-title font-weight-bold">Horario disponible</h5>

                            <a class="btn btn-danger" href="{{ route('citas.medicos', $medico->id) }}" role="button"><svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>Volver</a>

                    </div>
                        <hr>
                        {{-- <a class="btn btn-success" href="{{ route('usuarios.edit', $usuario->id) }}" role="button">Editar</a>
                        <p class="card-text">Nombre: {{ $usuario->nombre }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</p>

                        <p class="card-text">Ci: {{ $usuario->ci }}</p>
                        <p class="card-text">Telefono: {{ $usuario->telefono }}</p>
                        <p class="card-text">Email: {{ $usuario->email }}</p>

                       --}}

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

