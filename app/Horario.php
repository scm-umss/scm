<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'dia',
        'activo',
        'tm_hora_inicio',
        'tm_hora_fin',
        'tm_sucursal',
        'tm_especialidad',
        'tt_hora_inicio',
        'tt_hora_fin',
        'tt_sucursal',
        'tt_especialidad',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
