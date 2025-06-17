<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles/ '.$subTitle) }}
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-slate-700 text-sm rounded-md px-3 text-white py-2">Back</a>
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ isset($role) ? route('roles.update',$role->id) : route('roles.store')  }}">
                        @csrf
                        @if(isset($role))
                            @method('PUT')
                        @endif
                        <label class="text-lg font-medium">Name</label>
                        <div class="my-3">
                            <input type="text" name="name" placeholder="Enter Name" value="{{ isset($role) ? $role->name : old('name')  }}" class="border-gray-300 shodow-sm w-1/2 rounded-lg">
                            @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-4 mb-3">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                        <div class="mt-3">
                                            <input type="checkbox" name="permissions[]" {{ in_array($permission->name, old('permissions', isset($role) ? $role->permissions->pluck('name')->toArray() : [])) ? 'checked' : '' }} id="{{ $permission->name }}" value="{{ $permission->name }}" class="rounded">
                                            <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                        </div>
                                @endforeach
                            @endif
                        </div>
                        <button class="bg-slate-700 text-sm rounded-md px-5 text-white py-3">{{ isset($role) ? 'Update' : 'Submit'  }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
