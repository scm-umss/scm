<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitaHistorial extends Model
{
    protected $fillable = [
        'cita_id','user_id','evento','descripcion'
    ];
    public function cita(){
        return $this->belongsTo(Cita::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
