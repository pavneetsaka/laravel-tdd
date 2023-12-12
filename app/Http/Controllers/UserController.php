<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Traits\ModuleAccessibility;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ModuleAccessibility;

    public function index()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $canEditUsers = request()->user()->can('isAllowed', Module::byRouteName('edit.user'));
        $canDeleteUsers = request()->user()->can('isAllowed', Module::byRouteName('delete.user'));

        return view('admin.users.index', [
            'users' => User::with('role')->get(),
            'canEditUsers' => $canEditUsers,
            'canDeleteUsers' => $canDeleteUsers
        ]);
    }

    public function create()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        return view('admin.users.create');
    }

    public function store()
    {
        // $this->authorize('manage', User::class);
        $this->allowedAcitvity();

        $attributes = request()->validate([
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        User::create($attributes);

        return redirect('/admin/users')->with(['success' => 'Registration completed']);
    }

    public function edit(User $user)
    {
        // $this->authorize('manage', $user);
        $this->allowedAcitvity();

        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user)
    {
        // $this->authorize('manage', $user);
        $this->allowedAcitvity();

         $attributes = request()->validate([
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'sometimes'
        ]);

        if(empty($attributes['password'])){
            unset($attributes['password']);
        }

        $user->update($attributes);

        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {
        // $this->authorize('manage', $user);
        $this->allowedAcitvity();

        $user->delete();

        return redirect('/admin/users');
    }
}
