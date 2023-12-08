@props([
    'role' => new \App\Models\Role,
    'action' => 'Create',
    'modules'
])

@csrf
    <div class="lg:grid lg:grid-cols-2 gap-6">
        <div class="form-group mb-3">
            <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Name:</label>
            <div class="mt-2.5">
                <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $role->name }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="form-group mb-3">
            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Is Admin:</label>
            <div class="mt-2.5">
                <select class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="is_admin">
                    <option value="">Select option</option>
                    <option {{ $role->is_admin?'selected':'' }} value="1">Yes</option>
                    <option {{ !$role->is_admin?'selected':'' }} value="0">No</option>
                </select>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('is_admin')" />
        </div>
    </div>
    <div class="">
        @php
            $assignedModules = $role->access->pluck('id')->toArray();
        @endphp
        <label for="modules" class="block text-sm font-semibold leading-6 text-gray-900">Modules:</label>
        @foreach($modules as $module)
            <div class="parent">
                <label><input type="checkbox" name="modules[]" value="{{ $module->id }}" {{ (in_array($module->id, $assignedModules)?'checked':'') }}>&nbsp;{{ $module->name }}</label>
            </div>
            <div>
                <ul class="ml-5 mb-3 child">
                    @foreach($module->children as $child)
                        <li><label><input type="checkbox" name="modules[]" value="{{ $child->id }}" {{ (in_array($child->id, $assignedModules)?'checked':'') }}>&nbsp;{{ $child->name }}</label></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <button class="bg-blue-500 hover:bg-blue-600 rounded text-sm text-white py-2 px-4" type="submit">{{ $action }}</button>
    </div>