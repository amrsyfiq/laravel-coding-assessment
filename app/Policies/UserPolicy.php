<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $current_user, User $user)
    {
        if ($user->hasRole('Admin')) {
            return false;
        } else {
            return $current_user->id != $user->id;
        }
    }

    public function profile(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }

    public function password(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }

    public function destroy(User $current_user, User $user)
    {
        return $current_user->hasRole('Admin') && $current_user->id !== $user->id;
    }
}
