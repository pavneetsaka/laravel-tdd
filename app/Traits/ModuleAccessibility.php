<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Module;

trait ModuleAccessibility
{
    public function allowedAcitvity($module = NULL)
    {
        /* --  ROUTES --- */
        $routeName = request()->route()->getName();

        /* --- URL PARAMETERS ---- */
        $parentUrl = request()->segments();
        $urlAction = request()->segment(count($parentUrl));

        /* --- GET MODULE BASED ON ROUTE NAME ---- */
        $module = $module ?? Module::byRouteName($routeName);
        if($module)
        {
            /* --- Validate module based on UserPolicy ---- */
            $this->authorize('isAllowed', $module);
        }
        else
        {
            return abort(404);
        }
    }
}