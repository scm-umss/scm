<?php

namespace App;

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

    public function paciente()
    {
        return $this->belongsTo(User::class);
    }

    public function medico()
    {
        return $this->belongsTo(User::class);
    }
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }
}
