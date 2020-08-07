<?php

namespace App\Policies;

use App\Horario;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HorarioPolicy
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
     * @param  \App\Horario  $horario
     * @return mixed
     */
    public function view(User $user, Horario $horario)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Horario  $horario
     * @return mixed
     */
    public function update(User $user, User $horario)
    {
        return $user->id === $horario->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Horario  $horario
     * @return mixed
     */
    public function delete(User $user, Horario $horario)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Horario  $horario
     * @return mixed
     */
    public function restore(User $user, Horario $horario)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Horario  $horario
     * @return mixed
     */
    public function forceDelete(User $user, Horario $horario)
    {
        //
    }
}
