@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="/admin/roles" class="text-sm" title="">Roles</a>&nbsp;/ Create Role
        </h2>
    </x-header>
@endsection

@section('content')
    <x-wrapper class="max-w-3xl">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight m-10 text-center">
            Create a role
        </h2>
        <div class="px-6 pb-8 text-gray-900">
            <form action="/admin/roles" method="POST" accept-charset="utf-8" class="">
                {{-- <x-modules.form :modules="$modules" /> --}}
            </form>
        </div>
    </x-wrapper>
@endsection