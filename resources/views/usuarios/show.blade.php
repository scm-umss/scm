@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
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
                        <p class="card-text"> <strong>Nombre:</strong> {{ $usuario->nombreCompleto }}</p>

                        <p class="card-text"><strong>CI:</strong> {{ $usuario->ci }}</p>
                        <p class="card-text"><strong>Fecha Nacimiento:</strong> {{ $usuario->fecha_nacimiento->isoFormat('LLL') }}</p>
                        <p class="card-text"><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $usuario->email }}</p>

                        <p class="card-text"><strong>Estado:</strong>
                            @if ($usuario->activo)
                                <span class="badge badge-success p-1"> Activo</span>
                            @else
                            <span class="badge badge-danger"> Inactivo</span>
                            @endif </p>

                        <p class="card-text"><small class="text-muted">Registrado desde: {{ $usuario->created_at->isoFormat('LLLL') }}</small></p>

                                <hr>
                                <div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @if ($usuario->roles->pluck('slug')->contains('medico'))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="medico-tab" data-toggle="tab" href="#medico" role="tab" aria-controls="home" aria-selected="true">Medico</a>
                                        </li>
                                        @endif
                                        @if ($usuario->roles->pluck('slug')->contains('paciente'))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="paciente-tab" data-toggle="tab" href="#paciente" role="tab" aria-controls="profile" aria-selected="false">Paciente</a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @if ($usuario->roles->pluck('slug')->contains('medico'))
                                        <div class="tab-pane fade show active" id="medico" role="tabpanel" aria-labelledby="home-tab">
                                            <p class="card-text">Tus especialidades: {{ $usuario->especialidades->pluck('nombre')->implode(', ') }}</p>
                                            <div>
                                                <a href="{{ route('horarios.edit', $usuario->id) }}" class="btn btn-info" dusk="crear-horario-{{ $usuario->id }}">Ver Horarios</a>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($usuario->roles->pluck('slug')->contains('paciente'))
                                        <div class="tab-pane fade @if(! $usuario->roles->pluck('slug')->contains('medico')) show active @endif" id="paciente" role="tabpanel" aria-labelledby="profile-tab">Tu informacion como paciente
                                            <p class="card-text"><strong>Matrícula:</strong> {{ $usuario->matricula }}</p>
                                            <hr>
                                            <p>Tus proximas citas se mostrarán aquí</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            {{-- @endif --}}
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
