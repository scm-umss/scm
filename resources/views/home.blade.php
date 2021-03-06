@extends('admin.layouts.plantilla')

@section('content')

<section class="content">
    <div class="container-fluid">
        @if ($rol == 'admin')
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $pacientes }}</h3>

                        <p>Pacientes registrados y activos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <a href="{{ route('pacientes.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $medicos }}<sup style="font-size: 20px"></sup></h3>

                        <p>Médicos registrados y activos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <a href="{{ route('medicos.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $especialidades }}</h3>

                        <p>Especialidades</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <a href="{{ route('especialidad.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $citas }}</h3>

                        <p>Citas Pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <a href="{{ route('citas.pendientes') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        @elseif($rol == 'medico')
            @include('citas.tablas.confirmada')
        @elseif($rol == 'paciente')
        <div class="row justify-content-center">
            @include('citas.tablas.confirmada')
        </div>

        @endif

    </div><!-- /.container-fluid -->
</section>
@endsection
