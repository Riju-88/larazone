{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Thread') }}
        </h2>
    </x-slot>

    <div>
        <h1>Create a New Thread</h1>
        <form method="POST" action="{{ route('category.threads.store', ['category' => $category->id]) }}">

            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}"> <!-- Add this hidden input field -->
   
            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" class="form-input" required>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                <textarea name="content" id="content" class="form-textarea" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Create Thread</button>
        </form>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Thread') }}
        </h2>
    </x-slot>

    <div class="mx-4 mt-8">
    <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">Create a New Thread</h1>
        <form method="POST" action="{{ route('category.threads.store', ['category' => $category->id]) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
    
            <!-- Title -->
            <div class="mb-4 bg-white rounded-box p-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" class="w-full form-input rounded-box text-gray-700" required>
            </div>
    
            <!-- Content -->
            <div class="mb-4 bg-white rounded-box p-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                <input id="content" type="hidden" name="content">
                <trix-editor input="content" class="text-gray-700"></trix-editor>
            </div>
    
            <!-- File Upload -->
            <div class="mb-4">
                <label for="files" class="block text-sm font-bold mb-2">Upload Files:</label>

                <input type="file" name="files[]" id="files"
                    class="file-input file-input-bordered file-input-primary w-full max-w-xs bg-transparent" multiple>
            </div>
    
            <div class="flex justify-center my-4">
                <button type="submit" class="btn btn-success px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full transition duration-300 ease-in-out">Create Thread</button>
            </div>
        </form>
    </div>
    </div>
    


</x-app-layout>
