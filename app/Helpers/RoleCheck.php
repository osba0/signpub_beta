<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\UserRole;

class RoleCheck
{
    /**
     * @param User $user
     * @param string $role
     * @return bool|mixed
     */
    public function check(User $user, string $role)
    {
        // Admin has everything
        if ($user->hasRole(UserRole::ROLE_ADMIN)) {
            return true;
        }

        return $user->hasRole($role);
    }
}
