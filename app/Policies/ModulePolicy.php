<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Module;

class ModulePolicy
{
    public function isAllowed(User $user, Module $module)
    {
        return ($user->role->is_admin || $user->role->access->contains($module));
    }
}
