@extends('layouts.app')

@section('content')
<div class="container col-md-8">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4> Mis citas</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#citas-pendientes"
                        aria-selected="true">Citas pendientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#proximas-citas"
                        aria-selected="false">Próximas citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#historial-citas"
                        aria-selected="false">Historial de citas</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="citas-pendientes" role="tabpanel">
                    @include('citas.tablas.pendiente')
                </div>
                <div class="tab-pane fade" id="proximas-citas" role="tabpanel">
                    @include('citas.tablas.confirmada')
                </div>
                <div class="tab-pane fade" id="historial-citas" role="tabpanel">
                    @include('citas.tablas.historial')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
