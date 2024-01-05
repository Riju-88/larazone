<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <p class="text-center p-4 bg-gray-800 text-3xl font-bold mt-10">{{ $category->name }}</p>
    <div class="container mx-auto p-4 min-h-screen">

        <h1 class="text-2xl font-semibold mb-6">List of Threads</h1>

        @foreach ($threads->sortByDesc('created_at') as $thread)
            <div class="bg-neutral shadow-md rounded-3xl p-6 mb-6">
                <h2 class="text-3xl font-bold mb-2">{{ $thread->title }}</h2>
                <p class="mb-2 text-gray-500">Posted {{ $thread->created_at->diffForHumans() }}</p>
                <div class="text-wrap break-words overflow-hidden overflow-ellipsis h-20">{!! $thread->content !!}</div>

                <div class="flex items-center gap-2 mt-4">
                    <a href="{{ route('threads.show', ['category' => $category, 'thread' => $thread]) }}"
                        class="text-primary  btn btn-outline btn-primary rounded-full" title="View Threads"
                        title="View Thread">
                        {{-- <span class="material-symbols-outlined text-4xl">
                        article
                    </span> --}}
                        View Thread
                    </a>


                    @auth
                        @if (auth()->user()->id === $thread->user_id)
                            <a href="{{ route('threads.edit', ['category' => $category, 'thread' => $thread]) }}"
                                class="flex">
                                <span class="material-symbols-outlined text-primary text-3xl" title="edit">
                                    edit
                                </span>
                            </a>

                            {{-- Delete thread --}}
                            @include('threads.delete_thread')
                        @endif

                        {{-- Report thread --}}
                        @include('threads.report_thread')
                    @endauth
                </div>
            </div>
        @endforeach

        <!-- Pagination links -->
        <div class="flex justify-center m-4 pagination-container">
            {{ $threads->links() }}
        </div>

        @auth
            <div class="fixed bottom-4 right-4 z-10">
                <a href="{{ route('category.threads.create', ['category' => $category]) }}"
                    class=" mx-auto mt-4 btn  btn-primary rounded-full" title="Add Thread">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    New Thread
                </a>
            </div>
        @endauth
    </div>


</x-app-layout>
