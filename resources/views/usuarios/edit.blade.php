@extends('layouts.app')

@section('content')
{{-- @foreach ($usuario->roles as $rol)
<li>{{ dd($rol->nombre) }}</li>

@endforeach --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Actualización de usuario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                        @csrf
                        @method('PUT')
                        <fieldset class="border p-4">
                            <legend class="text-primary">Datos personales</legend>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre:</label>

                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $usuario->nombre }}" autocomplete="nombre" autofocus>

                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ap_paterno" class="col-md-4 col-form-label text-md-right">Apellido paterno:</label>

                                <div class="col-md-6">
                                    <input id="ap_paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ $usuario->ap_paterno  }}" autocomplete="ap_paterno" autofocus>

                                    @error('ap_paterno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ap_materno" class="col-md-4 col-form-label text-md-right">Apellido materno:</label>

                                <div class="col-md-6">
                                    <input id="ap_materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ $usuario->ap_materno }}" autocomplete="ap_materno" autofocus>

                                    @error('ap_materno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ci" class="col-md-4 col-form-label text-md-right">C.I.:</label>

                                <div class="col-md-6">
                                    <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ $usuario->ci }}" autocomplete="ci" autofocus>

                                    @error('ci')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefono" class="col-md-4 col-form-label text-md-right">Teléfono:</label>

                                <div class="col-md-6">
                                    <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ $usuario->telefono }}"  autocomplete="telefono" autofocus>

                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rol" class="col-md-4 col-form-label text-md-right">Rol:</label>

                                <div class="col-md-6">
                                    {{-- <input id="rol" type="text" class="form-control @error('rol') is-invalid @enderror" name="rol" value="{{ old('rol') }}" required autocomplete="rol" autofocus> --}}

                                    {{-- <select name="rol" id="rol" class="form-control">
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}"

                                            @isset($usuario->roles[0]->nombre)
                                                @if ($rol->nombre == $usuario->roles[0]->nombre)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{ $rol->nombre }}</option>
                                        @endforeach
                                    </select> --}}

                                    @foreach ($roles as $rol)
                                        <input id="{{ $rol->slug }}" name="roles[]" type="checkbox" class="form-check-input checkbox" value="{{ $rol->id }}"
                                            @foreach($usuario->roles as $rol_usuario)
                                                @if ($rol->nombre == $rol_usuario->nombre)
                                                    checked
                                                @endif
                                            @endforeach
                                        >
                                        <label for="{{ $rol->slug }}" class="form-check-label">{{ $rol->nombre }}</label>
                                    @endforeach

                                    @error('rol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">Estado</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="estado">
                                        @foreach(["a" => "Activo", "i" => "Inactivo"] as $estado => $estadoTexto)
                                        <option value="{{ $estado }}" {{ $usuario->estado == $estado ? 'selected' : '' }}>{{ $estadoTexto }}</option>
                                        @endforeach
                                    </select>

                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-4">
                            <legend class="text-primary">Datos de acceso</legend>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $usuario->email }}" autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña:</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                </div>
                            </div>
                        </fieldset>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
