@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <form action="{{ route('horarios.update', $medico->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h4>Horario de: <span class="badge badge-secondary">{{ $medico->nombreCompleto }}</span></h4>
                    </div>
                    <div>
                        <a class="btn btn-danger" href="{{ redirect()->getUrlGenerator()->previous() }}" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Volver</a>
                        <button type="submit" class="btn btn-primary">Guardar Horario</button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                    @foreach (session('error') as $item)
                    <div class="alert alert-danger">
                        {{ $item }}
                    </div>

                    @endforeach
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Día</th>
                                <th scope="col">Turno</th>
                                <th scope="col">Horarios</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Especialidad</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horarios_medico as $key => $horario_dia)
                                <tr>
                                    <td>{{ $dias[$key] }}</td>
                                    <td><div class="form-check">
                                        <input id="tm_activo[{{$key}}]" name="tm_activo[{{$key}}]" value="{{$key}}"
                                        class="form-check-input" type="checkbox" dusk="tm_activo[{{$key}}]"
                                        @if ((is_array(old('tm_activo')) && in_array($key, old('tm_activo'))) or
                                            (!is_array(old('tm_activo')) && $horario_dia->tm_activo))
                                            checked
                                        @endif
                                        > <label for="tm_activo[{{$key}}]">Mañana</label>
                                    </td>

                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <select name="tm_hora_inicio[{{ $key }}]" id="tm_hora_inicio[{{ $key }}]" class="form-control" dusk="tm_hora_inicio[{{ $key }}]">
                                                    @foreach ($horario_tm as $hora_tm)
                                                    <option value="{{ $hora_tm }}"
                                                    @if ((is_array(old('tm_hora_inicio')) && in_array($hora_tm, old('tm_hora_inicio'))) or
                                                        (!is_array(old('tm_hora_inicio')) && ($horario_dia->tm_hora_inicio == $hora_tm.':00')))
                                                        selected
                                                    @endif>
                                                        {{$hora_tm}}

                                                    </option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col">
                                                <select name="tm_hora_fin[{{ $key }}]" id="tm_hora_fin[{{ $key }}]" class="form-control" dusk="tm_hora_fin[{{ $key }}]">
                                                    @foreach ($horario_tm as $hora_tm)
                                                    <option value="{{$hora_tm}}"
                                                    @if ((is_array(old('tm_hora_fin')) && in_array($hora_tm, old('tm_hora_fin'))) or
                                                        (!is_array(old('tm_hora_fin')) && ($horario_dia->tm_hora_fin == $hora_tm.':00')))
                                                        selected
                                                    @endif>
                                                        {{$hora_tm}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <select name="tm_sucursal[{{ $key }}]" id="tm_sucursal[{{ $key }}]" class="form-control" dusk="tm_sucursal[{{ $key }}]">
                                            {{-- <option value="0">--Seleccionar sucursal--</option> --}}
                                            @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}"
                                                @if ((is_array(old('tm_sucursal')) && in_array($sucursal->id, old('tm_sucursal'))) or
                                                    ((!is_array(old('tm_sucursal'))) && ($sucursal->id == $horario_dia->tm_sucursal)))
                                                    selected
                                                @endif
                                                >{{ $sucursal->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <select name="tm_especialidad[{{ $key }}]" id="tm_especialidad[{{ $key }}]" class="form-control" dusk="tm_especialidad[{{ $key }}]">
                                            {{-- <option value="0">--Seleccionar--</option> --}}
                                            @foreach ($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}"
                                                @if ((is_array(old('tm_especialidad')) && in_array($especialidad->id, old('tm_especialidad'))) or
                                                    ((!is_array(old('tm_especialidad'))) && ($especialidad->id == $horario_dia->tm_especialidad)))
                                                    selected
                                                @endif>{{ $especialidad->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><div class="form-check">
                                        <input id="tt_activo[{{ $key }}]" name="tt_activo[{{ $key }}]" value="{{ $key }}"
                                        class="form-check-input" type="checkbox" dusk="tt_activo[{{ $key }}]"
                                        @if ((is_array(old('tt_activo')) && in_array($key, old('tt_activo'))) or
                                            (!is_array(old('tt_activo')) && $horario_dia->tt_activo))
                                            checked
                                        @endif>
                                        <label for="tt_activo[{{ $key }}]">Tarde</label>
                                    </td>

                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <select name="tt_hora_inicio[{{ $key }}]" id="tt_hora_inicio[{{ $key }}]" class="form-control" dusk="tt_hora_inicio[{{ $key }}]">
                                                    @foreach ($horario_tt as $hora_tt)
                                                    <option value="{{$hora_tt}}" @if ((is_array(old('tt_hora_inicio')) && in_array($hora_tt, old('tt_hora_inicio'))) or
                                                    (!is_array(old('tt_hora_inicio')) && ($horario_dia->tt_hora_inicio == $hora_tt.':00')))
                                                    selected
                                                @endif>
                                                        {{$hora_tt}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col">
                                                <select name="tt_hora_fin[{{ $key }}]" id="tt_hora_fin[{{ $key }}]" class="form-control" dusk="tt_hora_fin[{{ $key }}]">
                                                    @foreach ($horario_tt as $hora_tt)
                                                    <option value="{{$hora_tt}}"
                                                    @if ((is_array(old('tt_hora_fin')) && in_array($hora_tt, old('tt_hora_fin'))) or
                                                        (!is_array(old('tt_hora_fin')) && ($horario_dia->tt_hora_fin == $hora_tt.':00')))
                                                        selected
                                                    @endif>
                                                        {{$hora_tt}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="tt_sucursal[{{ $key }}]" id="tt_sucursal[{{ $key }}]" class="form-control" dusk="tt_sucursal[{{ $key }}]">
                                            {{-- <option value="0">--Seleccionar sucursal--</option> --}}
                                            @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}"
                                            @if ((is_array(old('tt_sucursal')) && in_array($sucursal->id, old('tt_sucursal'))) or
                                                ((!is_array(old('tt_sucursal'))) && ($sucursal->id == $horario_dia->tt_sucursal)))
                                                selected
                                            @endif>{{ $sucursal->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <select name="tt_especialidad[{{ $key }}]" id="tt_especialidad[{{ $key }}]" class="form-control" dusk="tt_especialidad[{{ $key }}]">
                                            {{-- <option value="0">--Seleccionar--</option> --}}
                                            @foreach ($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}"
                                                @if ((is_array(old('tt_especialidad')) && in_array($especialidad->id, old('tt_especialidad'))) or
                                                    ((!is_array(old('tt_especialidad'))) && ($especialidad->id == $horario_dia->tt_especialidad)))
                                                    selected
                                                @endif>{{ $especialidad->nombre }}</option>
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
    </div>
</div>
@endsection

