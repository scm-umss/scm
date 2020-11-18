@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow">
        @if (session('rol'))
            <div class="alert alert-danger">
                {{ session('rol') }}
            </div>
            @endif
        <div class="card-header d-flex justify-content-between">

            <h4> @yield('cabecera') </h4>
            <div class="">
                <a class="btn btn-outline-success" href="{{ route('citas.create') }}"><i class="fas fa-plus-circle"></i> Crear Cita</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            @yield('citas')

        </div>
    </div>
</div>
@endsection
