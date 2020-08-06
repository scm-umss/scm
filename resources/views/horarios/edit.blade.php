@extends('layouts.app')

@section('content')

{{-- {{ dd($horario_medico) }} --}}
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12"> --}}
            <form action="{{ route('horarios.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header d-flex justify-content-between">Horario de trabajo
                        <button type="submit" class="btn btn-primary">Guardar Horario</button>
                        {{-- <a href="{{ route('usuarios.index') }}" class="btn btn-danger px-4" role="button">Cancelar</a> --}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Día</th>
                                        <th scope="col">Activo</th>
                                        <th scope="col">Turno mañana</th>
                                        <th scope="col">Sucursal</th>
                                        <th scope="col">Especialidad</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($horarios_medico as $key => $horario_dia)
                                    {{-- <input type="hidden" name="dia_tm[]" id="dia_tm" value="{{ $key }}"> --}}
                                        <tr>
                                            <td>{{ $dias[$key] }}</td>
                                            <td><div class="form-check">
                                                <input id="tm_activo" name="tm_activo[]" value="{{ $key }}"
                                                class="form-check-input" type="checkbox"
                                                @if ($horario_dia->tm_activo)
                                                    checked
                                                @endif
                                                >
                                            </td>

                                            <td>
                                                <div class="row">
                                                    <div class="col">
                                                        <select name="tm_hora_inicio[]" id="" class="form-control">
                                                            @foreach ($horario_tm as $hora_tm)
                                                            <option value="{{ $hora_tm }}">
                                                               {{$hora_tm}}
                                                            </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <select name="tm_hora_fin[]" id="tm_sucursal" class="form-control">
                                                            @foreach ($horario_tm as $hora_tm)
                                                            <option value="{{$hora_tm}}">
                                                               {{$hora_tm}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <select name="tm_sucursal[]" id="" class="form-control">
                                                    {{-- <option value="0">--Seleccionar sucursal--</option> --}}
                                                    @foreach ($sucursales as $sucursal)
                                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="tm_especialidad[]" id="tm_especialidad" class="form-control">
                                                    {{-- <option value="0">--Seleccionar--</option> --}}
                                                    @foreach ($especialidades as $especialidad)
                                                    <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Día</th>
                                        <th scope="col">Activo</th>
                                        <th scope="col">Turno Tarde</th>
                                        <th scope="col">Sucursal</th>
                                        <th scope="col">Especialidad</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($horarios_medico as $key => $horario_dia)
                                    {{-- <input type="hidden" name="dia_tt[]" id="dia_tt" value="{{ $key }}"> --}}
                                        <tr>
                                            <td>{{ $dias[$key] }}</td>
                                            <td><div class="form-check">
                                                <input id="tt_activo" name="tt_activo[]" value="{{ $key }}" class="form-check-input" type="checkbox"
                                                @if ($horario_dia->tt_activo)
                                                    checked
                                                @endif>
                                            </td>

                                            <td>
                                                <div class="row">
                                                    <div class="col">
                                                        <select name="tt_hora_inicio[]" id="" class="form-control">
                                                            @foreach ($horario_tt as $hora_tt)
                                                            <option value="{{$hora_tt}}">
                                                               {{$hora_tt}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <select name="tt_hora_fin[]" id="" class="form-control">
                                                            @foreach ($horario_tt as $hora_tt)
                                                            <option value="{{$hora_tt}}">
                                                               {{$hora_tt}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="tt_sucursal[]" id="tt_sucursal" class="form-control">
                                                    {{-- <option value="0">--Seleccionar sucursal--</option> --}}
                                                    @foreach ($sucursales as $sucursal)
                                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="tt_especialidad[]" id="tt_especialidad" class="form-control">
                                                    {{-- <option value="0">--Seleccionar--</option> --}}
                                                    @foreach ($especialidades as $especialidad)
                                                    <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>

            </form>
        {{-- </div> --}}
    </div>
</div>
@endsection

