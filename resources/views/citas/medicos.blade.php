@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h4>Medicos de la especialidad: {{ $especialidad->nombre }}</h4>

                    <a class="btn btn-danger" href="{{ route('citas.create') }}" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Volver</a>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-center flex-wrap">
                        @foreach ($medicos as $medico)
                    <div class="card m-3" style="width: 18rem;">
                        <img class="card-img-top" src="/storage/{{ $medico->imagen }}" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title">{{ $medico->nombre }}</h5>
                          <p class="card-text">{{ $medico->ap_paterno }}</p>
                          <a href="{{ route('citas.horario', ['medico' => $medico->id, 'especialidad' => $especialidad->id]) }}" class="btn btn-primary">Seleccionar</a>
                        </div>
                      </div>

                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

