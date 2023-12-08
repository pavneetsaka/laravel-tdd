<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Module;

class UserPolicy
{
    public function manage(User $user)
    {
        return $user->role->is_admin;
    }
}
