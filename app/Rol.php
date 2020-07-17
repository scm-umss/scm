<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'rol_user');
    }
}
