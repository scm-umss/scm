@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">

            <form action="{{ route('rol.store') }}" method="POST" class="col-md-9 col-xs-12 card card-body">
                @csrf



                    <div class="form-group">
                        <label for="nombre"> Nombre:</label>
                        <input type="text"
                            name="nombre"
                            id="nombre"
                            placeholder="Nombre de rol"
                            value="{{ old('nombre') }}"
                            class="form-control @error('nombre') is-invalid @enderror mb-4">
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        <label for="slug"> Slug:</label>
                        <input type="text"
                            name="slug"
                            id="slug"
                            placeholder="slug de rol"
                            value="{{ old('slug') }}"
                            class="form-control @error('slug') is-invalid @enderror mb-4">
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        <label for="descripcion"> Descripción:</label>
                        <input type="text"
                            name="descripcion"
                            id="descripcion"
                            placeholder="Descripción del rol"
                            value="{{ old('descripcion') }}"
                            class="form-control @error('descripcion') is-invalid @enderror mb-4">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <button type="submit" class="btn btn-primary btn-md">Guardar</button>
                        <a href="{{ route('rol.index') }}" class="btn btn-danger px4">Cancelar</a>
                    </div>


            </form>

        </div>
    </div>

@endsection

