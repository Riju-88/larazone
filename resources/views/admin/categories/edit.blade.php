<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>
    <div class="min-h-screen"> 
    <form method="post" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" class="ajax-form" id="edit-category-{{ $category->id }}') }}" class="max-w-xl mx-auto mt-10">
        @csrf
        @method('PATCH')
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Category Name</label>
            <input type="text" name="name" id="name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:focus:ring-gray-900 dark:focus:border-gray-900" value="{{ $category->name }}">
        </div>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Category Description</label>
            <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:focus:ring-gray-900 dark:focus:border-gray-900"> {{ $category->description }}</textarea>
        </div>
        <button type="submit" class="w-full px-3 py-4 text-white bg-indigo-500 rounded-md focus:bg-indigo-600 focus:outline-none">Edit Category</button>
    </form>
</div>
</x-app-layout>
