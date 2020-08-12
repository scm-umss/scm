@extends('layouts.app')

@section('content')
{{-- {{ dd($u->roles()->nombre) }} --}}

<div class="container col-md-8">
    <div class="card shadow">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            <h4>Lista de pacientes</h4>
            <div class="d-flex align-right">
                <a class="btn btn-success" href="{{ route('usuarios.create') }}" role="button" dusk="crear-paciente">Nuevo Paciente</a>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Fotos</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->nombre }} {{ $paciente->ap_paterno }} {{ $paciente->ap_materno }}</td>
                            <td>{{ $paciente->telefono }}</td>

                            <td><img src="/storage/{{ $paciente->imagen }}" style="width:60px"></td>
                            <td>
                                {{-- <a href="{{ route('horarios.edit', $paciente->id) }}" class="btn btn-sm btn-info" dusk="ver-horarios-{{ $paciente->id }}">Ver Horarios</a> --}}
                                <a href="{{ route('usuarios.show', ['usuario' => $paciente->id]) }}" class="btn btn-sm btn-info" dusk="ver-detalles-{{ $paciente->id }}">Detalles</a>
                                <a href="{{ route('usuarios.edit', ['usuario' => $paciente->id]) }}" class="btn btn-sm btn-secondary" dusk="editar-paciente-{{ $paciente->id }}">Editar</a>
                                <a id="eliminar-paciente-{{ $paciente->id }}" class="btn btn-sm btn-danger" dusk="eliminar-paciente- $paciente->id  }}" >Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event)=>{
        // $( "#eliminar-paciente" ).click(function() {
            
        //     console.log('Clkick 2');
        // });
        @foreach ($pacientes as $paciente)
            document.getElementById('eliminar-paciente-{{ $paciente->id }}').onclick = function() {
                swal({
                    title: "¿Está seguro de dar de baja al Paciente?",
                    text: "Una vez dado de baja, ya no estará en la lista de pacientes.",
                    icon: "warning",
                    dangerMode: true,
                    buttons: ["Cancelar", "Dar de baja!"],
                })
                .then((quiereBorrar) => {
                if (quiereBorrar) {
                    window.location.href = '{{ route("usuarios.destroy", $paciente->id ) }}';    
                }
                });
            };
        @endforeach
    });
</script>
@endsection
