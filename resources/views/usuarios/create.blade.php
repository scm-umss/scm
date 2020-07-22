@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Registrar usuario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf

                        <fieldset class="border p-4">
                            <legend class="text-primary">Datos personales</legend>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre:</label>

                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" autocomplete="nombre" autofocus>

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
                                    <input id="ap_paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ old('ap_paterno') }}" autocomplete="ap_paterno" autofocus>

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
                                    <input id="ap_materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ old('ap_materno') }}" autocomplete="ap_materno" autofocus>

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
                                    <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" autocomplete="ci" autofocus>

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
                                    <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}"  autocomplete="telefono" autofocus>

                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rol" class="col-md-4 col-form-label text-md-right">Roles:</label>

                                <div class="col-md-6">
                                    @foreach ($roles as $rol)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            id="{{ $rol->slug }}"
                                            name="roles[]"
                                            value="{{ $rol->id }}"
                                        >
                                        <label class="form-check-label" for="{{ $rol->slug }}">{{ $rol->nombre }}</label>
                                    </div>
                                    @endforeach
{{--
                                        <input id="{{ $rol->slug }}" name="roles[]" type="checkbox" class="custom-control-input" value="{{ $rol->id }}">
                                        <label for="" class="form-check-label">{{ $rol->nombre }}</label> --}}


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

                                        <option value="{{ $estado }}">{{ $estadoTexto }}</option>
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
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                </div>
                            </div>

                        </fieldset>



                        <div class="form-group mt-3 d-flex justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-primary p3">
                                    Registrar Usuario
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
