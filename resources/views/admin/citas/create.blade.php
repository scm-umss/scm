@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Citas médicas</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('citas.store') }}">
                        @csrf

                        <fieldset class="border p-4">
                            <legend class="text-primary">Agendar cita</legend>

                            <listar-especialidades></listar-especialidades>

                            {{-- <fecha-component></fecha-component> --}}

                            {{-- <div class="form-group row">
                                <label for="fecha_programada" class="col-md-4 col-form-label text-md-right">Fecha:</label>

                                <div class="col-md-6">
                                    <input id="fecha_programada" type="date" class="form-control @error('fecha_programada') is-invalid @enderror" name="fecha_programada" value="{{ old('fecha_programada') }}" autocomplete="fecha_programada" autofocus>

                                    @error('fecha_programada')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hora_programada" class="col-md-4 col-form-label text-md-right">Hora:</label>

                                <div class="col-md-6">
                                    <input id="hora_programada" type="time" class="form-control @error('hora_programada') is-invalid @enderror" name="hora_programada" value="{{ old('hora_programada') }}" autocomplete="hora_programada" autofocus>

                                    @error('hora_programada')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                        </fieldset>



                        <div class="form-group mt-3 d-flex justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-primary p3">
                                    Registrar Cita
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
