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
        'email', 'password', 'ap_paterno', 'ap_materno', 'nombre',
        'telefono', 'imagen', 'matricula', 'fecha_nacimiento'
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

    protected $dates = [
        'fecha_nacimiento',
        'deleted_at'
    ];

    public function scopeBuscar($query, $nombre, $ap_paterno, $ap_materno){
        if ($nombre or $ap_paterno or $ap_materno) {
            return $query->where('nombre', 'LIKE', "%$nombre%")
                        ->orWhere('ap_paterno', 'LIKE', "%$ap_paterno%")
                        ->orWhere('ap_materno', 'LIKE', "%$ap_materno%");
        }
    }

    public function roles(){
        return $this->belongsToMany(Rol::class, 'rol_user');
    }

    public function horarios(){
        return $this->hasMany(Horario::class);
    }
    public function citasMedico(){
        return $this->hasMany(Cita::class,'medico_id');
    }

    public function citasAtendidas(){
        return $this->citasMedico()->where('estado','Atendida');
    }
    public function citasCanceladas(){
        return $this->citasMedico()->where('estado','Cancelada');
    }

    public function citasPaciente(){
        return $this->hasMany(Cita::class,'paciente_id');
    }

    public function citasConfirmadas(){
        return $this->citasPaciente()->where('estado','Confirmada');
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

    // public function perfil(){
    //     return $this->hasOne(Perfil::class);
    // }

    public function getNombreCompletoAttribute(){
		return "$this->nombre $this->ap_paterno $this->ap_materno";
    }

    public function getActivoAttribute(){
        return $this->where('deleted_at',null);
    }

    public function especialidadesMedico(){
        return $this->especialidades();
    }
}
