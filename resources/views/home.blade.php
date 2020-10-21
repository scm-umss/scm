@extends('admin.layouts.plantilla')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($rol == 'admin')
                        <h5>Aquí estarán disponibles la sección correspondiente a la gestión <span class="badge badge-info">Administrativa</span> del sistema</h5>
                    @elseif($rol == 'medico')
                        <h5>Aquí estarán disponibles la sección correspondiente a la gestión de sus citas del <span class="badge badge-info">médico</span></h5>
                    @elseif($rol == 'paciente')
                        <h5>Aquí estarán disponibles la sección correspondiente a la gestión de sus citas del <span class="badge badge-info">paciente</span></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
