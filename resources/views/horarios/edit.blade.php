@extends('layouts.app')

@section('content')

{{-- {{ dd($horario_medico) }} --}}
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12"> --}}
            <form action="{{ route('horarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h4>Horario de trabajo de: <span class="badge badge-secondary">{{ $usuario->nombre }} {{ $usuario->ap_paterno }} {{ $usuario->ap_paterno }}</span></h4>
                        </div>
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
                                            <input id="tm_activo" name="tm_activo[{{$key}}]" value="{{$key}}"
                                            class="form-check-input" type="checkbox"
                                            @if ((is_array(old('tm_activo')) && in_array($key, old('tm_activo'))) or
                                                (!is_array(old('tm_activo')) && $horario_dia->tm_activo))
                                                checked
                                            @endif
                                            > <label for="tm_activo">Mañana</label>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="tm_hora_inicio[]" id="" class="form-control">
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
                                                    <select name="tm_hora_fin[]" id="tm_sucursal" class="form-control">
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
                                            <select name="tm_sucursal[]" id="" class="form-control">
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
                                            <select name="tm_especialidad[]" id="tm_especialidad" class="form-control">
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
                                            <input id="tt_activo" name="tt_activo[]" value="{{ $key }}" class="form-check-input" type="checkbox"
                                            @if ((is_array(old('tt_activo')) && in_array($key, old('tt_activo'))) or
                                                (!is_array(old('tt_activo')) && $horario_dia->tt_activo))
                                                checked
                                            @endif>
                                            <label for="tt_activo">Tarde</label>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="tt_hora_inicio[]" id="" class="form-control">
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
                                                    <select name="tt_hora_fin[]" id="" class="form-control">
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
                                            <select name="tt_sucursal[]" id="tt_sucursal" class="form-control">
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
                                            <select name="tt_especialidad[]" id="tt_especialidad" class="form-control">
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
        {{-- </div> --}}
    </div>
</div>
@endsection

