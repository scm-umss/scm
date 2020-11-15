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
                @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
                @endif
                <div class="row no-gutters">
                    <div class="col-md-4 bg-secondary">
                        <img src="/storage/{{$usuario->imagen}}" class="card-img rounded-circle" alt="foto">
                        <div class="container text-center mt-4">
                            @if (auth()->user()->isSuperAdmin())
                            <a class="btn btn-warning d-block" href="{{ route('usuarios.edit', $usuario->id) }}"
                                role="button">Editar</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body bg-light">
                            <div class="container bg-secondary p-4 mb-4 d-flex justify-content-between">
                                <h4 class="card-title">Estás registrado como:
                                    {{ $usuario->roles->pluck('nombre')->implode(', ') }}</h4>
                                    <a class="btn btn-danger" href="{{ redirect()->getUrlGenerator()->previous() }}" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Volver</a>
                            </div>

                            {{-- <hr> --}}

                            <p class="card-text"> <strong>Nombre:</strong> {{ $usuario->nombreCompleto }}</p>

                            <p class="card-text"><strong>CI:</strong> {{ $usuario->ci }}</p>
                            <p class="card-text"><strong>Fecha Nacimiento:</strong> {{ $usuario->fecha_nacimiento->isoFormat('DD [de] MMMM [de] YYYY') }}</p>
                            <p class="card-text"><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ $usuario->email }}</p>

                            <p class="card-text"><strong>Estado:</strong>
                                @if ($usuario->activo)
                                <span class="badge badge-success p-1"> Activo</span>
                                @else
                                <span class="badge badge-danger"> Inactivo</span>
                                @endif </p>

                            <p class="card-text"><small class="text-muted">Registrado desde:
                                    {{ $usuario->created_at->isoFormat('LLLL') }}</small></p>

                            <hr>
                            <div class="indigo">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @if ($usuario->roles->pluck('slug')->contains('medico'))
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="medico-tab" data-toggle="tab" href="#medico"
                                            role="tab" aria-controls="home" aria-selected="true">Medico</a>
                                    </li>
                                    @endif
                                    @if ($usuario->roles->pluck('slug')->contains('paciente'))
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link @if(! $usuario->roles->pluck('slug')->contains('medico')) show active @endif" id="paciente-tab" data-toggle="tab" href="#paciente"
                                            role="tab" aria-controls="profile" aria-selected="false">Paciente</a>
                                    </li>
                                    @endif
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    @if ($usuario->roles->pluck('slug')->contains('medico'))
                                    <div class="tab-pane fade show active" id="medico" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        @if($usuario->especialidades->count())
                                        <p class="card-text"><strong>Tus especialidades:</strong>
                                            {{ $usuario->especialidades->pluck('nombre')->implode(', ') }}</p>
                                        @else
                                            <p>Aún no tiene asignado una especialidad</p>
                                        @endif
                                        <div>
                                            <a href="{{ route('horarios.edit', $usuario->id) }}" class="btn btn-info"
                                                dusk="crear-horario-{{ $usuario->id }}">Gestionar Horario</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($usuario->roles->pluck('slug')->contains('paciente'))
                                    <div class="tab-pane fade @if(! $usuario->roles->pluck('slug')->contains('medico')) show active @endif"
                                        id="paciente" role="tabpanel" aria-labelledby="profile-tab">
                                        <p><strong>Tu informacion como paciente</strong></p>
                                        <p class="card-text"><strong>Matrícula:</strong> {{ $usuario->matricula }}</p>
                                        <hr>

                                        <div class="card card-outline card-primary">
                                            <div class="card-header">Tus próximas citas</div>
                                            <div class="card-body">
                                                @forelse ($citas_confirmadas as $cita)
                                                    <p><strong> Fecha programada: </strong> {{ $cita->fecha_programada->format('Y-m-d') }}</p>
                                                    <p><strong> Hora programada: </strong> {{ $cita->hora_programada }}</p>
                                                    <p><strong> Especilidad: </strong> {{ $cita->especialidad->nombre }}</p>
                                                    <p><strong> Médico: </strong> {{ $cita->medico->nombreCompleto }}</p>
                                                    <hr>
                                                @empty
                                                    <p>Aún no tienes citas confirmadas</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
