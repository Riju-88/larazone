<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-200 mt-16 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="m-4 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <form method="POST"
                action="{{ route('category.thread.posts.update', ['category' => $category, 'thread' => $thread, 'post' => $post]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-4 bg-white rounded-box p-4">
                    <input id="content" type="hidden" name="content">
                    <trix-editor input="content" class="text-gray-700" required>
                        {!! $post->content !!}
                    </trix-editor>
                </div>
                <button type="submit" class="btn btn-success rounded-full">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
