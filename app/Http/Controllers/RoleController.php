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

        Module::where('is_active', true)->get();

        return view('admin.roles.create');
    }

    public function store()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = $this->validateFields();

        $role = Role::create([
            'name' => $attributes['name'],
            'is_admin' => $attributes['is_admin']
        ]);

        if(isset($attributes['modules']) && !empty($attributes['modules'])){
            $role->assign($attributes['modules']);
        }

        return redirect('/admin/roles');
    }

    public function edit(Role $role)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Role $role)
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = $this->validateFields();

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

    protected function validateFields()
    {
        return request()->validate([
            'name' => 'required|unique:roles,name',
            'is_admin' => 'required',
            'modules' => 'sometimes|required|array'
        ]);
    }
}
