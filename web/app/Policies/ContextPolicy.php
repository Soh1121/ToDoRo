<?php

namespace App\Policies;

use App\Context;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContextPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Context  $context
     * @return mixed
     */
    public function view(User $user, Context $context)
    {
        return $user->id == $context->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @param  \App\Context $context
     * @return mixed
     */
    public function create(User $user, Context $context)
    {
        return $user->id == $context->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Context  $context
     * @return mixed
     */
    public function update(User $user, Context $context)
    {
        return $user->id == $context->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Context  $context
     * @return mixed
     */
    public function delete(User $user, Context $context)
    {
        return $user->id == $context->user_id;
    }
}
