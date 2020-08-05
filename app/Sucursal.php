<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    //
    protected $table = 'sucursal';

    protected $fillable = [
        'nombre', 'descripcion', 'telefonos', 'direccion', 'geo_latitud', 'geo_longitud',
    ];

    public function horarios(){
        return $this->hasMany(Horario::class);
    }
}
