<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    //
    protected $fillable = [
        'nombre', 'descripcion',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'especialidad_user');
    }
}
