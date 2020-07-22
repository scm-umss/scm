<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
        'imagen', 'user_id',
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }
}
