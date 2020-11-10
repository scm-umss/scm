@extends('admin.layouts.plantilla')
@section('content')

<div class="container">
    <pacientes-registrados f_ini="{{ $f_ini }}" f_fin="{{ $f_fin }}"></pacientes-registrados>
</div>

@endsection
