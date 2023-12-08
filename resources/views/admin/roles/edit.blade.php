@extends('layouts.app')

@section('header')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <a href="/admin/roles" class="text-sm" title="">Roles</a>&nbsp;/ Update Role
        </h2>
    </x-header>
@endsection

@section('content')
    <x-wrapper class="max-w-3xl">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight m-10 text-center">
            Update a Role
        </h2>
        <div class="px-6 pb-8 text-gray-900">
            <form action="/admin/roles/{{ $role->id }}" method="POST" accept-charset="utf-8" class="">
                @method('PATCH')
                <x-roles.form action="Update" :role="$role" :modules="$modules" />
            </form>
        </div>
    </x-wrapper>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".parent label input").on('click',function(){
                var _parent=$(this);
                var nextli=$(this).parents('.parent').next().children().children();

                if(_parent.prop('checked')){
                    console.log('parent checked');
                    nextli.each(function(){
                        $(this).find('input').prop('checked',true);
                    });
                }
                else{
                    console.log('parent un checked');
                    nextli.each(function(){
                        $(this).find('input').prop('checked',false);
                    });
                }
            });

            $(".child label input").on('click',function(){
                var child=$(this);
                var parentinput=child.closest('div').prev().find('input');
                var sibblingsli=child.closest('ul').find('li');

                if(child.prop('checked')){
                    console.log('child checked');
                    parentinput.prop('checked',true);
                }
                else{
                    console.log('child unchecked');
                    var status=true;
                    sibblingsli.each(function(){
                        console.log('sibb');
                        if($(this).children().prop('checked')) status=false;
                    });
                    if(status) parentinput.prop('checked',false);
                }
            });
        })
    </script>
@endsection