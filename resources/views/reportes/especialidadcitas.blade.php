@extends('admin.layouts.plantilla')
@section('content')

<div class="container">
    <especialidad-citas f_ini="{{ $f_ini }}" f_fin="{{ $f_fin }}"></especialidad-citas>
</div>

@endsection
