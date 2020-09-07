@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">

                <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="/storage/{{$usuario->imagen}}" class="card-img" alt="foto">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div></div>
                        <h5 class="card-title">Estás registrado como: {{ $usuario->roles->pluck('nombre')->implode(', ') }}</h5>
                        <hr>
                        <a class="btn btn-success" href="{{ route('usuarios.edit', $usuario->id) }}" role="button">Editar</a>
                        <p class="card-text">Nombre: {{ $usuario->nombreCompleto }}</p>

                        <p class="card-text">Ci: {{ $usuario->ci }}</p>
                        <p class="card-text">Telefono: {{ $usuario->telefono }}</p>
                        <p class="card-text">Email: {{ $usuario->email }}</p>

                        <p class="card-text">Estado: @if ($usuario->estado == 'a')
                                Activo
                            @else
                                Inactivo
                            @endif </p>

                        <p class="card-text"><small class="text-muted">registrado desde: {{ $usuario->created_at->isoFormat('LLLL') }}</small></p>
                        {{-- {{ dd($usuario->roles->pluck('id')) }} --}}
                        {{-- @foreach ($roles as $id => $rol) --}}
                        {{-- {{ dd($id) }} --}}
                            @if ($usuario->roles->pluck('slug')->contains('medico') or $usuario->roles->pluck('slug')->contains('paciente') )

                                <hr>
                                <div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="medico-tab" data-toggle="tab" href="#medico" role="tab" aria-controls="home" aria-selected="true">Medico</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="paciente-tab" data-toggle="tab" href="#paciente" role="tab" aria-controls="profile" aria-selected="false">Paciente</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="medico" role="tabpanel" aria-labelledby="home-tab">
                                            <p class="card-text">Especialidades: {{ $usuario->especialidades->pluck('nombre')->implode(', ') }}</p>
                                            <div>
                                                <a href="{{ route('horarios.edit', $usuario->id) }}" class="btn btn-info" dusk="crear-horario-{{ $usuario->id }}">Ver Horarios</a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="paciente" role="tabpanel" aria-labelledby="profile-tab">Informacion del paciente

                                        </div>
                                    </div>
                                </div>
                            @endif
                        {{-- @endforeach --}}
                        {{-- @if ($usuario->roles)

                        @endif --}}

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
