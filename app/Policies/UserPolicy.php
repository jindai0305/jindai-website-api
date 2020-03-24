<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends InitialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can login.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function login(User $user)
    {
        return !$user->isDisabled();
    }

    /**
     * Determine whether the user can comment.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function comment(User $user)
    {
        return !$user->isMuted();
    }

    /**
     *  Determine whether the user can move other to black
     *
     * @param User $user
     * @return bool
     */
    public function black(User $user)
    {
        return $user->is_super;
    }

    /**
     *  Determine whether the user is super
     *
     * @param User $user
     * @return bool
     */
    public function super(User $user) {
        return $user->is_super;
    }
}
