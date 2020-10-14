@extends('layouts.app')

@section('content')
<div class="container col-md-8">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4> @yield('cabecera')</h4>
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
