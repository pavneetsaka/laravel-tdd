@props([
    'user' => new \App\Models\User,
    'action' => 'Create',
    'roles' => \App\Models\Role::where('is_active', true)->get()
])

@csrf
    <div class="lg:grid lg:grid-cols-2 gap-6">
        <div class="form-group mb-3">
            <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Name:</label>
            <div class="mt-2.5">
                <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $user->name }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="form-group mb-3">
            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email:</label>
            <div class="mt-2.5">
                <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $user->email }}">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
    </div>
    <div class="lg:grid lg:grid-cols-2 gap-6">
        <div class="form-group mb-3">
            <label for="password" class="block text-sm font-semibold leading-6 text-gray-900">Password:</label>
            <div class="mt-2.5">
                <input type="password" name="password" id="password" autocomplete="password" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>
        <div class="form-group mb-3">
            <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Role:</label>
            <div class="mt-2.5">
                <select class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="role_id">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option {{ $role->id == $user->role_id?'selected':'' }} value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>
    </div>
    <div class="text-center mt-3">
        <button class="bg-blue-500 hover:bg-blue-600 rounded text-sm text-white py-2 px-4" type="submit">{{ $action }}</button>
    </div>