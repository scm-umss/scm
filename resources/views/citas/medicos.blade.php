@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h4>Medicos de la especialidad: {{ $especialidad->nombre }}</h4>
                    <a class="btn btn-danger" href="{{ route('citas.create') }}" role="button"><svg viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>Volver</a>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-center flex-wrap">
                        @foreach ($medicos as $medico)
                    <div class="card m-3" style="width: 18rem;">
                        <img class="card-img-top" src="/storage/{{ $medico->imagen }}" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title">{{ $medico->nombre }}</h5>
                          <p class="card-text">{{ $medico->ap_paterno }}</p>
                          <a href="{{ route('citas.horario', $medico->id) }}" class="btn btn-primary">Seleccionar</a>
                        </div>
                      </div>

                    @endforeach
                    </div>

                    {{-- <form method="POST" action="{{ route('citas.store') }}" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group mt-3 d-flex justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-primary p3">
                                    Registrar Usuario
                                </button>
                            </div>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

