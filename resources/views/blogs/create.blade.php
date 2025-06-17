<x-app-layout>
    <x-slot name="header">
       <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blogs/ '.$subTitle) }}
            </h2>
            <a href="{{ route('blogs.index') }}" class="bg-slate-700 text-sm rounded-md px-3 text-white py-2">Back</a>
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ isset($blog) ? route('blogs.update',$blog->id) : route('blogs.store')  }}">
                        @csrf
                        @if(isset($blog))
                            @method('PUT')
                        @endif
                        <label class="text-lg font-medium">Title</label>
                        <div class="my-3">
                            <input type="text" name="title" placeholder="Enter title" value="{{ isset($blog) ? $blog->title : old('title')  }}" class="border-gray-300 shodow-sm w-1/2 rounded-lg">
                            @error('title')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="text-lg font-medium">Content</label>
                        <div class="my-3">
                            <textarea name="text" id="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Content" cols="30" rows="10" >{{ isset($blog) ? $blog->text : old('text')  }}</textarea>
                        </div>

                        <label class="text-lg font-medium">Author</label>
                        <div class="my-3">
                            <input type="text" name="author" placeholder="Enter author" value="{{ isset($blog) ? $blog->author : old('author')  }}" class="border-gray-300 shodow-sm w-1/2 rounded-lg">
                            @error('author')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>


                        <button class="bg-slate-700 text-sm rounded-md px-5 text-white py-3">{{ isset($role) ? 'Update' : 'Submit'  }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
