@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Roles
        </h2>
        @can('isAllowed', \App\Models\Module::byRouteName('roles'))
        <a href="/admin/roles/create" title="" class="bg-blue-500 text-sm px-4 py-2 rounded text-white">Create Role</a>
        @endcan
    </x-header>
@endsection

@section('content')
    <x-wrapper class="max-w-5xl">
        <div class="p-6 text-gray-900">
            <table class="w-full border-separate">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $key=>$role)
                    @php
                        $tdClass = "p-4 text-slate-500";
                        if(!$loop->last){
                            $tdClass .= ' border-b border-slate-100';
                        }
                    @endphp

                    <tr class="text-center">
                        <td class="{{ $tdClass }}">{{ $key+1 }}</td>
                        <td class="{{ $tdClass }}">{{ $role->name }}</td>
                        <td class="{{ $tdClass }} flex justify-center">
                            @can('isAllowed', \App\Models\Module::byRouteName('edit.role'))
                            <a href="/admin/roles/{{ $role->id }}/edit"  class="bg-blue-500 hover:bg-blue-600 px-4 py-2 text-sm rounded text-white" title="">Edit</a>
                            @endcan
                            &nbsp;&nbsp;
                            @can('isAllowed', \App\Models\Module::byRouteName('delete.role'))
                            <form action="/admin/roles/{{ $role->id }}" method="POST" accept-charset="utf-8">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-sm px-4 py-2 rounded text-white">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr colspan="4" class="text-center">
                        <td>No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-wrapper>
@endsection
