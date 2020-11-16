@extends('layouts.app')

@section('content')
    <div class="container col-md-8">
        <div class="row justify-content-center mt-5">
            <form action="{{ route('especialidad.store') }}" method="POST" class="col-md-9 col-xs-12 card card-body" enctype="multipart/form-data">
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
                                <label for="imagen">Imagen:</label>
                                <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror">
                                {{-- <div>
                                    <p>Imagen Actual</p>
                                    <img src="" style="width:300px"/>
                                </div> --}}
                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <div class="pt-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success btn-md mr-2"><i class="fas fa-check-circle"></i> Guardar</button>
                        <a href="{{ route('especialidad.index') }}" class="btn btn-outline-danger px4"><i class="fas fa-arrow-circle-left"></i> Cancelar</a>
                        </div>
                    </div>
                </fieldset>

            </form>

        </div>
    </div>

@endsection
