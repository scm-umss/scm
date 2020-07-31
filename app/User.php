<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'ap_paterno', 'ap_materno', 'nombre', 'telefono', 'estado', 'imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->perfil()->create();
        });
    }

    public function roles(){
        return $this->belongsToMany(Rol::class, 'rol_user');
    }

    public function isSuperAdmin() {
        return $this->tieneRol(['admin']);
    }

    public function especialidades(){
        return $this->belongsToMany(Especialidad::class, 'especialidad_user');
    }

    public function tieneRol(array $roles){
        foreach($roles as $rol){
            foreach ($this->roles as $usuarioRol) {
                if($usuarioRol->slug == $rol){
                    return true;
                }
            }
        }
    }

    public function perfil(){
        return $this->hasOne(Perfil::class);
    }
}
