@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <form action="{{ route('especialidad.update', ['especialidad' => $especialidad->id]) }}"
        class="col-md-9 col-xs-12 card card-body"
        method="POST">
            @csrf
            @method('PUT')
            <fieldset class="border p-4">
                <legend class="text-primary">Complete el formulario</legend>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text"
                        name="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        id="nombre"
                        placeholder="Tu nombre"
                        value="{{ $especialidad->nombre }}"
                    >

                        @error('nombre')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    <label for="descripcion">Descripcion:</label>
                    <input type="text"
                        name="descripcion"
                        class="form-control @error('descripcion') is-invalid @enderror"
                        id="descripcion"
                        placeholder="Tu descripcion"
                        value="{{ $especialidad->descripcion }}"
                    >

                        @error('descripcion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                </div>

            </fieldset>

        </form>

    </div>
</div>
@endsection

