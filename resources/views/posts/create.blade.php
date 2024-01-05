<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Create a New Post in Thread: {{ $thread->title }}</h3>

                    <!-- Post creation form -->
                    <form method="POST" action="{{ route('posts.store', $thread) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <label for="content" class="block font-medium">Post Content</label>
                            <textarea name="content" id="content" rows="4"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-gray-900 dark:focus:border-gray-900"></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="files" class="block text-gray-700 text-sm font-bold mb-2">Upload
                                Files:</label>
                            <input type="file" name="files[]" id="files" class="form-input" multiple>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
