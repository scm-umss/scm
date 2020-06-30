@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <form action="{{ route('especialidades.store') }}" method="POST" class="col-md-9 col-xs-12 card card-body">
                @csrf

                <fieldset class="border p-4">
                    <legend class="text-primary">Complete el formulario para registrar una especialidad</legend>
                    <div class="form-group">
                        <label for="nombre"> Nombre:</label>
                        <input type="text"
                            name="nombre"
                            id="nombre"
                            placeholder="Nombre de especialidad"
                            value="{{ old('nombre') }}"
                            class="form-control @error('nombre') is-invalid @enderror mb-4">
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        <label for="descripcion"> Descripción:</label>
                        <input type="text"
                            name="descripcion"
                            id="descripcion"
                            placeholder="Descripción de especialidad"
                            value="{{ old('descripcion') }}"
                            class="form-control @error('descripcion') is-invalid @enderror mb-4">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <button type="submit" class="btn btn-primary btn-md">Guardar</button>
                    </div>
                </fieldset>

            </form>

        </div>
    </div>

@endsection
