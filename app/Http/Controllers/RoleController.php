<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Traits\ModuleAccessibility;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    use ModuleAccessibility;

    public function index()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $roles = Role::where('is_active', true)->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $modules = Module::where(['is_active' => true,'parent_id' => NULL])->with('children')->get();

        return view('admin.roles.create', compact('modules'));
    }

    public function store()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = request()->validate([
            'name' => 'required|unique:roles,name',
            'is_admin' => 'required',
            'modules' => 'sometimes|required|array'
        ]);

        $role = Role::create($attributes);

        if(isset($attributes['modules']) && !empty($attributes['modules'])){
            $role->assign($attributes['modules']);
        }

        return redirect('/admin/roles');
    }

    public function edit(Role $role)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $modules = Module::where(['is_active' => true,'parent_id' => NULL])->with('children')->get();

        return view('admin.roles.edit', compact('role','modules'));
    }

    public function update(Role $role)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = request()->validate([
            'name' => 'required',
            'is_admin' => 'required',
            'modules' => 'sometimes|required|array'
        ]);

        $role->update($attributes);

        if(isset($attributes['modules']) && !empty($attributes['modules'])){
            $role->assign($attributes['modules']);
        }

        return redirect('/admin/roles');
    }

    public function destroy(Role $role)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $role->is_active = false;
        $role->save();

        return redirect('/admin/roles');
    }
}
