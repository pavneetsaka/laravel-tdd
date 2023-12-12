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

        $canEditModules = request()->user()->can('isAllowed', Module::byRouteName('edit.module'));
        $canDeleteModules = request()->user()->can('isAllowed', Module::byRouteName('delete.module'));

        $modules = Module::where(['is_active' => true, 'parent_id' => null])->with('children')->get();

        return view('admin.module.index', compact('modules', 'canEditModules', 'canDeleteModules'));
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
            'name' => 'required',
            'parent_id' => 'sometimes',
            'slug' => '',
            'route_uri' => 'required'
        ]);

        //Additonal validation to avoid duplicate module name wrt parent_id
        $where = "parent_id IS NULL";
        if($attributes['parent_id'] == "true")
        {
            $where = "parent_id = {$attributes['parent_id']}";
        }
        $validateName = Module::where('name', $attributes['name'])->whereRaw($where)->first();
        if($validateName){
            return redirect()->back()->withErrors(['name' => 'The name has already been taken.']);
        }

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
