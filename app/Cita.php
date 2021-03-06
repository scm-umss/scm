<?php

namespace App;

use App\Sucursal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    //
    protected $fillable = [
        'fecha_hora',
        'estado',
        'paciente_id',
        'medico_id',
        'numero_ficha',
        'especialidad_id',
    ];

    protected $dates =[
        'fecha_programada'
    ];
    protected $casts = [
        'hora_programada' => 'time:H:i',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function medico()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class)->withTrashed();
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
    public function getHoraProgramadaAttribute($hora){
        $hora = new Carbon($hora);
        return $this->hora_programda = $hora->format('H:i');
    }
    public function citaHistorials(){
        return $this->hasMany(CitaHistorial::class);
    }
}
