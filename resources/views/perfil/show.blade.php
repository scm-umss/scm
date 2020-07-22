@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3 shadow">
                <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="..." class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div></div>
                        <h5 class="card-title">Estás registrado como: {{ $perfil->usuario->roles[0]->nombre }}</h5>
                        <hr>
                        <p class="card-text">Nombre: {{ $perfil->usuario->nombre }} {{ $perfil->usuario->ap_paterno }} {{ $perfil->usuario->ap_materno }}</p>

                        <p class="card-text">Telefono: {{ $perfil->usuario->telefono }}</p>
                        <p class="card-text">Email: {{ $perfil->usuario->email }}</p>

                        <p class="card-text"><small class="text-muted">registrado desde: {{ $perfil->created_at }}</small></p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
