<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        public $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->menu = Module::where([
                            'parent_id' => NULL,
                            'is_active' => true,
                            'role_id' => auth()->user()->role_id
                        ])->with('children')->get();

        return view('components.menu', $menu);
    }
}
