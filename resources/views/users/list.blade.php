<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles') }}
            </h2>
            {{-- <a href="{{ route('users.create') }}" class="bg-slate-700 text-sm rounded-md px-3 text-white py-2">Create</a> --}}
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</td>
                        <th class="px-6 py-3 text-left">Name</td>
                        <th class="px-6 py-3 text-left">Email</td>
                        <th class="px-6 py-3 text-left">Roles</td>
                        <th class="px-6 py-3 text-left" width="180">Created At</td>
                        <th class="px-6 py-3 text-center" width="180">Action</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($users->isNotEmpty())
                       @foreach ($users as $user)                           
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left">{{ $user->id }}</td>
                            <th class="px-6 py-3 text-left">{{ $user->name }}</td>
                            <th class="px-6 py-3 text-left">{{ $user->email }}</td>
                            <th class="px-6 py-3 text-left">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                            <th class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                            <th class="px-6 py-3 text-center">
                                <a href="{{ route('users.edit',$user->id) }}" class="bg-slate-700 text-sm rounded-md  text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                <a onclick="delete_permission({{  $user->id }})"  href="javascript:void(0)" class="bg-red-600 text-sm rounded-md  text-white px-3 py-2 hover:bg-red-500">Delete</a>
                            </td>
                        </tr>
                       @endforeach 
                    @endif
                </tbody>
            </table>
            <div class="my-3"></div>
            
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function delete_permission(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: "{{ route('users.destroy', ':id') }}".replace(':id', id), 
                        type: "DELETE",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            alert(response.message || "Role deleted successfully.");
                            location.reload(); // reload or remove row from table
                        },
                        error: function (xhr) {
                            alert(xhr.responseJSON.message || "An error occurred.");
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
