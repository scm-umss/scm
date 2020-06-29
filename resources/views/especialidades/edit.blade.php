@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 bg-white p-3">
        <form action="{{ route('especialidades.update', ['especialidad' => $especialidad->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="descripcion">Descripcion</label>
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

        </form>
    </div>
</div>
@endsection

