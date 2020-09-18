<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'dia',
        'tm_activo',
        'tm_hora_inicio',
        'tm_hora_fin',
        'tm_sucursal',
        'tm_especialidad',
        'tm_consultorio',
        'tt_activo',
        'tt_hora_inicio',
        'tt_hora_fin',
        'tt_sucursal',
        'tt_especialidad',
        'tt_consultorio',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
