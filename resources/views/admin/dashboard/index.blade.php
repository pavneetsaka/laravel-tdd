@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-header>
@endsection

@section('content')
    <x-wrapper class="max-w-7xl">
        <div class="p-6 text-gray-900">
            <div class="lg:flex lg:flex-wrap -mx-3">Welcome to your dashboard</div>
        </div>
    </x-wrapper>
@endsection