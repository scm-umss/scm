@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">Actualización de usuario
                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger px-4" role="button">Cancelar</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <fieldset class="border p-4">
                            <legend class="text-primary">Datos personales</legend>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombres:</label>

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
                                <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">Fecha Nacimiento:</label>

                                <div class="col-md-6">
                                    <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento',$usuario->fecha_nacimiento->format('Y-m-d')) }}">

                                    @error('fecha_nacimiento')
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
                                    @foreach ($roles as $rol)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                            type="checkbox"
                                            id="{{ $rol->slug }}"
                                            name="roles[]"
                                            value="{{ $rol->id }}"
                                            @foreach($usuario->roles as $rol_usuario)
                                                @if ($rol->nombre == $rol_usuario->nombre)
                                                    checked
                                                @endif
                                            @endforeach
                                             >
                                            <label class="form-check-label" for="{{ $rol->slug }}">{{ $rol->nombre }}</label>
                                        </div>
                                    @endforeach
                                    @error('rol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="imagen" class="col-md-4 col-form-label text-md-right">Foto</label>
                                <div class="content py-4">
                                    <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror">
                                <div>
                                    <p class="pt-4">Imagen Actual</p>
                                    <img src="/storage/{{ $usuario->imagen }}" style="width:300px"/>
                                </div>
                                @error('imagen')
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
                                    </br>
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

                        <fieldset class="border p-4">
                            <legend class="text-primary">Datos de medico</legend>
                            <div class="form-group row">
                                <label for="especialidades" class="col-md-4 col-form-label text-md-right">Especialidades:</label>
                                <div class="col-md-6">
                                    <select  id="especialidades" class="form-control" name="especialidades[]" multiple>
                                        @foreach($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}"
                                                @foreach ($usuario->especialidades as $esp_usuario)
                                                    {{ $esp_usuario->id == $especialidad->id ? 'selected' : ''}}
                                                @endforeach
                                            >{{ $especialidad->nombre }}</option>
                                        @endforeach
                                    </select>
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


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    $("#especialidades").select2({
            allowClear:true,
            placeholder: 'Seleccionar especialidad'
        });
});
</script>

@endsection
