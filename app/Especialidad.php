<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'descripcion',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'especialidad_user');
    }
}
