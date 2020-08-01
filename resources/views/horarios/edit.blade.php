@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

{{-- {{ dd($horarios) }} --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">Actualización de usuario
                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger px-4" role="button">Cancelar</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="" >
                        @csrf
                        @method('PUT')
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Día</th>
                                    <th scope="col">Activo</th>
                                    <th scope="col">Turno mañana</th>
                                    <th scope="col">Turno Tarde</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($horarios as $key => $horario)
                                    <tr>
                                        <td>{{ $dias[$key] }}</td>
                                        <td><div class="form-check">
                                            <input id="" name="activo[]" value="" class="form-check-input" type="checkbox" checked>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="tm_hora_inicio[]" id="" class="form-control">
                                                        <option value="">
                                                            8:00
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <select name="tm_hora_fin[]" id="" class="form-control">
                                                        <option value="">
                                                            8:00
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="tt_hora_inicio[]" id="" class="form-control">
                                                        <option value="">
                                                            14:00
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <select name="tt_hora_fin[]" id="" class="form-control">
                                                        <option value="">
                                                            14:00
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>


                                        <td>


                                            {{-- <a href="{{ route('usuarios.show', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-info">Detalles</a>
                                            <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}" class="btn btn-sm btn-secondary" dusk="editar-usuario-{{ $usuario->id }}">Editar</a>
                                            <a href="{{ route('usuarios.destroy', $usuario->id) }}" class="btn btn-sm btn-danger" dusk="eliminar-usuario-{{ $usuario->id }}" >Eliminar</a> --}}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    $("#especialidades").select2({
            allowClear:true,
            placeholder: 'Seleccionar especialidad'
        });
});
</script>

@endsection
