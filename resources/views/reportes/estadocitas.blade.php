@extends('admin.layouts.plantilla')

@section('content')
<div class="container">
    <estado-citas f_ini="{{ $f_ini }}" f_fin="{{ $f_fin }}"></estado-citas>
</div>
@endsection

