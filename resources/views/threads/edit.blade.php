<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 mt-12 leading-tight">
            {{ __('Edit Thread') }}
        </h2>
    </x-slot>

    <div class="mx-4 mt-8">
        <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">Edit Thread</h1>
        <form class="ajax-form" method="POST" action="{{ route('threads.update', ['category' => $category, 'thread' => $thread]) }}">
            @csrf
            {{-- @method('PUT') --}}
            <div class="mb-4 bg-white rounded-box p-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" class="w-full form-input rounded-box text-gray-700" value="{{ $thread->title }}" required>
            </div>
    
            <div class="mb-4 bg-white rounded-box p-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                <input id="content" type="hidden" name="content">
                <trix-editor input="content" class="text-gray-700">
                    {!! $thread->content !!}
                </trix-editor>
            </div>
    
            <div class="flex justify-center">
                <button type="submit" class="btn btn-success px-6 py-3  hover:bg-green-800 text-white rounded-full transition duration-300 ease-in-out">Update Thread</button>
            </div>
        </form>
    </div>
    </div>
    
</x-app-layout>
