@extends('admin.layouts.plantilla')
@section('content')

<div class="container">
    <citas-medico f_ini="{{ $f_ini }}" f_fin="{{ $f_fin }}"></citas-medico>
</div>

@endsection
