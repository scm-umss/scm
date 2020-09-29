@extends('layouts.app')

@section('content')


<div class="container col-md-6">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de Roles</h4>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->nombre }}</td>
                            <td>{{ $rol->slug }}</td>
                            <td>{{ $rol->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

