@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <form action="{{ route('especialidad.update', ['especialidad' => $especialidad->id]) }}"
        class="col-md-9 col-xs-12 card card-body"
        method="POST" enctype="multipart/form-data">
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

                        <label for="imagen">Imagen:</label>
                        <div class="content py-4">
                            <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror">
                        <div>
                            <p class="pt-4">Imagen Actual</p>
                            <img src="/storage/{{ $especialidad->imagen }}" style="width:300px"/>
                        </div>
                        @error('imagen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                    <a href="{{ route('especialidad.index') }}" class="btn btn-danger px4">Cancelar</a>
                </div>

            </fieldset>

        </form>

    </div>
</div>
@endsection

