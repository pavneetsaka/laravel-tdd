@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modules
        </h2>
        @can('isAllowed', \App\Models\Module::byRouteName('create.module'))
        <a href="/admin/modules/create" title="" class="bg-blue-500 text-sm px-4 py-2 rounded text-white">Create Module</a>
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
                    @forelse($modules as $key=>$module)
                    @php
                        $tdClass = "p-4 text-slate-500";
                        if(!$loop->last){
                            $tdClass .= ' border-b border-slate-100';
                        }
                    @endphp

                    <tr class="text-center">
                        <td class="{{ $tdClass }}">{{ $key+1 }}</td>
                        <td class="{{ $tdClass }}">{{ $module->name }}</td>
                        <td class="{{ $tdClass }} flex justify-center">
                            @if(isset($canEditModules) && $canEditModules)
                            <a href="/admin/modules/{{ $module->id }}/edit"  class="bg-blue-500 hover:bg-blue-600 px-4 py-2 text-sm rounded text-white" title="">Edit</a>
                            @endif
                            &nbsp;&nbsp;
                            @if(isset($canDeleteModules) && $canDeleteModules)
                            <form action="/admin/modules/{{ $module->id }}" method="POST" accept-charset="utf-8">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-sm px-4 py-2 rounded text-white">Delete</button>
                            </form>
                            @endif
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
