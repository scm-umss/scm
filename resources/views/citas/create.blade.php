@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h4>Registrar Cita</h4>
                    <a class="btn btn-danger text-white" href="" role="button">Cancelar</a>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-center flex-wrap">
                        @foreach ($especialidades as $especialidad)
                    <div class="card m-3" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('storage/especialidades.png') }}" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title">{{ $especialidad->nombre }}</h5>
                          <p class="card-text">{{ $especialidad->descripcion }}</p>
                          <a href="{{ route('citas.medicos', $especialidad->id) }}" class="btn btn-primary">Seleccionar</a>
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

