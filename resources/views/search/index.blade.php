<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>

    <div class="mx-auto mt-8 max-w-4xl">

        {{-- Search results --}}
        
        <div class="text-xl md:text-4xl mb-4 mx-4">Search results for: {{ $keyword }} </div>
    
        <div class="bg-gray-800 p-2 w-full mb-4 rounded-md">
        <div class="text-2xl mx-4 text-center font-semibold">Threads</div>
        </div>
        @forelse ($threadResults as $thread)
            <div
                class="card p-4 bg-neutral shadow-md rounded-md hover:scale-105 hover:shadow-xl transition duration-300 ease-in-out m-4">
                <a href="{{ route('threads.show', ['category' => $thread->category, 'thread' => $thread]) }}"
                    class="text-lg font-semibold mix-blend-diff hover:underline">{{ $thread->title }}</a>

                <div class="mt-2 overflow-hidden overflow-ellipsis h-20">{!! $thread->content !!}</div>
                <p class="mt-2 text-sm text-gray-500">(Category: {{ $thread->category->name }})</p>
            </div>
            @empty
            <div class=" p-4 m-4">   
                <p class="text-lg font-semibold text-center">No results to display.</p>
                </div>
        @endforelse

        <div class="flex justify-center m-4 pagination-container">
         
            @if(count($threadResults) > 0)
            {{ $threadResults->appends(['search' => $keyword])->links() }}
            @endif
           
        </div>
        <div class="bg-gray-800 p-2 w-full mb-4 rounded-md">
            <div class="text-2xl mx-4 text-center font-semibold">Posts</div>
            </div>

        @forelse ($postResults as $post)
            <div
                class="card p-4 bg-neutral shadow-md rounded-md hover:scale-105 hover:shadow-xl transition duration-300 ease-in-out m-4">

                <div class="mt-2 overflow-hidden overflow-ellipsis h-20">
                    <a
                        href="{{ route('threads.show', ['category' => $post->category_id, 'thread' => $post->thread_id]) . '#post-' . $post->id }}" class="hover:underline">

                        {!! $post->content !!}
                    </a>
                </div>
            </div>
            @empty
            <div class=" p-4 m-4">   
                <p class="text-lg font-semibold text-center">No results to display.</p>
                </div>
        @endforelse

        <div class="flex justify-center m-4 pagination-container">
         
            @if(count($postResults) > 0)
            {{ $postResults->appends(['search' => $keyword])->links() }}
            @endif
        </div>
    </div>



</x-app-layout>
