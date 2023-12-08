<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Traits\ModuleAccessibility;

class ModuleController extends Controller
{
    use ModuleAccessibility;

    public function index()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $modules = Module::where(['is_active' => true, 'parent_id' => null])->with('children')->get();

        return view('admin.module.index', compact('modules'));
    }

    public function create()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $modules = Module::where(['parent_id' => null])->get();

        return view('admin.module.create', compact('modules'));
    }

    public function store()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = request()->validate([
            'name' => 'required|unique:modules,name',
            'parent_id' => 'sometimes',
            'slug' => '',
            'route_uri' => 'required'
        ]);

        Module::create($attributes);

        return redirect('/admin/modules');
    }

    public function edit(Module $module)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity($module);

        $modules = Module::where(['parent_id' => null])->get();

        return view('admin.module.edit', compact('module','modules'));
    }

    public function update(Module $module)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity($module);

        $attributes = request()->validate([
            'name' => 'required',
            'parent_id' => 'sometimes',
            'slug' => '',
            'route_uri' => 'required'
        ]);

        $module->update($attributes);

        return redirect('/admin/modules');
    }

    public function destroy(Module $module)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $module->is_active = false;
        $module->save();

        return redirect('/admin/modules', $data);
    }
}
