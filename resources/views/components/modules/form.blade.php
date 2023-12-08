@props([
    'module' => new \App\Models\Module,
    'action' => 'Create',
    'modules' => $modules
])

@csrf
    <div class="lg:grid lg:grid-cols-2 gap-6">
        <div class="form-group mb-3">
            <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Name:</label>
            <div class="mt-2.5">
                <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $module->name }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="form-group mb-3">
            <label for="parent_id" class="block text-sm font-semibold leading-6 text-gray-900">Parent:</label>
            <div class="mt-2.5">
                <select class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="parent_id">
                    <option value="">Select Module</option>
                    @foreach($modules as $parent_module)
                        <option {{ $module->parent_id == $parent_module->id ? 'selected':'' }} value="{{ $parent_module->id }}">{{ $parent_module->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('parent_id')" />
        </div>
    </div>
    <div class="lg:grid lg:grid-cols-2 gap-6">
        <div class="form-group mb-3">
            <label for="slug" class="block text-sm font-semibold leading-6 text-gray-900">Slug:</label>
            <div class="mt-2.5">
                <input type="text" name="slug" id="slug" autocomplete="slug" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $module->slug }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
        </div>
        <div class="form-group mb-3">
            <label for="route_uri" class="block text-sm font-semibold leading-6 text-gray-900">Route:</label>
            <div class="mt-2.5">
                <input type="text" name="route_uri" id="route_uri" autocomplete="route_uri" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $module->route_uri }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('route_uri')" />
        </div>
    </div>
    <div class="text-center mt-3">
        <button class="bg-blue-500 hover:bg-blue-600 rounded text-sm text-white py-2 px-4" type="submit">{{ $action }}</button>
    </div>