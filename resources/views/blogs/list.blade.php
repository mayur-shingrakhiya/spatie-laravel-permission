<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blogs') }}
            </h2>
            <a href="{{ route('blogs.create') }}" class="bg-slate-700 text-sm rounded-md px-3 text-white py-2">Create</a>
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</td>
                        <th class="px-6 py-3 text-left">Title</td>
                        <th class="px-6 py-3 text-left">Author</td>
                        <th class="px-6 py-3 text-left" width="180">Created At</td>
                        <th class="px-6 py-3 text-center" width="180">Action</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($blogs->isNotEmpty())
                       @foreach ($blogs as $blog)                           
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left">{{ $blog->id }}</td>
                            <th class="px-6 py-3 text-left">{{ $blog->title }}</td>
                            <th class="px-6 py-3 text-left">{{ $blog->author }}</td>
                            <th class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</td>
                            <th class="px-6 py-3 text-center">
                                <a href="{{ route('blogs.edit',$blog->id) }}" class="bg-slate-700 text-sm rounded-md  text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                <a onclick="delete_permission({{  $blog->id }})"  href="javascript:void(0)" class="bg-red-600 text-sm rounded-md  text-white px-3 py-2 hover:bg-red-500">Delete</a>
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
                        url: "{{ route('blogs.destroy', ':id') }}".replace(':id', id), // or use a data attribute to build the full route
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
