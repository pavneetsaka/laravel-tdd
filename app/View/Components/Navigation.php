<?php

namespace App\View\Components;

use Closure;
use App\Models\Module;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu = [];
        if(auth()->user())
        {
            $accessibleModules = \DB::table('modules_access')->where('role_id', auth()->user()->role_id)->pluck('module_id')->toArray();

            $menu = Module::where([
                                'parent_id' => NULL,
                                'is_active' => true
                            ])->whereIn('id', $accessibleModules)->with('children')->get();
        }

        return view('components.navigation', compact('menu'));
    }
}
