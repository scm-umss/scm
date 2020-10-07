<?php

namespace App\Policies;

use App\Cita;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CitasPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Cita  $cita
     * @return mixed
     */
    public function view(User $user, Cita $cita)
    {
        return $user->id === $cita->paciente->id  or $user->id === $cita->medico->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // return $user->id === $cita->paciente->id;
        // return ($user->tieneRol(['admin']) || $user->hasRole('admin'));
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Cita  $cita
     * @return mixed
     */
    public function update(User $user, Cita $cita)
    {
        return $user->id === $cita->paciente->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Cita  $cita
     * @return mixed
     */
    public function delete(User $user, Cita $cita)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Cita  $cita
     * @return mixed
     */
    public function restore(User $user, Cita $cita)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Cita  $cita
     * @return mixed
     */
    public function forceDelete(User $user, Cita $cita)
    {
        //
    }
}
