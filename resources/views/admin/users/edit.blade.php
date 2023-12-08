@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="/admin/users" class="text-sm" title="">Users</a>&nbsp;/ Update User
        </h2>
        <a href="/admin/users/create" title="" class="bg-blue-500 text-sm px-4 py-2 rounded text-white">Create User</a>
    </x-header>
@endsection

@section('content')
    <x-wrapper class="max-w-3xl">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight m-10 text-center">
            Update User
        </h2>
        <div class="px-6 pb-8 text-gray-900">
            <form action="/admin/users/{{ $user->id }}" method="POST" accept-charset="utf-8" class="">
                @method('PATCH')
                <x-users.form :user="$user" action="Update" />
            </form>
        </div>
    </x-wrapper>
@endsection