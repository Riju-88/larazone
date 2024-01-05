<x-app-layout>
    <x-slot name="header" class="mt-8">
        {{-- success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    @include('threads.thread')

    @auth

        {{-- make comment --}}
        @include('threads.comment')

    @endauth

    <!-- List of Comments -->
    <div class="m-4 max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold mb-2">Comments</h2>
    </div>
    @if ($thread->posts->count() > 0)
        <div class="m-4 max-w-4xl mx-auto">
            @foreach ($thread->posts->sortByDesc('created_at') as $post)
                <div id="post-{{ $post->id }}" class="p-4 m-4 rounded-3xl shadow-md border border-primary bg-neutral">
                    <div class="flex space-x-4 items-start">
                        {{-- User image --}}
                        <div>
                            @if ($post->user->profile_image)
                                <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User Image"
                                    class="w-12 h-12 rounded-full">
                            @else
                                <img src="{{ asset('storage/default/user.svg') }}" alt="Default User Image"
                                    class="w-12 h-12 rounded-full">
                            @endif
                        </div>

                        <div class="flex-1 space-y-2">
                            <div class="flex justify-between items-center">
                                <a class="text-xl font-semibold mix-blend-difference hover:underline"
                                    href="{{ route('view_user.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                <p class=" mix-blend-difference">{{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            {{-- daisyui badge --}}
                            <div
                                class="badge {{ $post->user->badge === 'user'
                                    ? 'bg-user'
                                    : ($post->user->badge === 'mod'
                                        ? 'bg-mod'
                                        : ($post->user->badge === 'pro'
                                            ? 'bg-pro'
                                            : ($post->user->badge === 'new user'
                                                ? 'bg-newUser'
                                                : ($post->user->badge === 'negative influencer'
                                                    ? 'bg-troll'
                                                    : 'bg-primary')))) }}">
                                {{ $post->user->badge }}
                            </div>

                            <div x-cloak class="mt-2">
                                <div class="break-words mix-blend-difference">{!! $post->content !!}</div>
                                {{-- Attached Files --}}
                                @include('threads.comment_files')


                            </div>

                            <div class="flex flex-col w-full">

                                <div class="divider"></div>

                            </div>
                            @auth
                                <div class="flex mt-4 space-x-4">
                                    <!-- Upvote and Downvote for comments -->
                                    @include('threads.votes')

                                    {{-- Edit comment --}}
                                    @include('threads.editComment')

                                    {{-- Report post --}}
                                    @include('threads.reportPost')

                                    <!-- Admin delete button -->
                                    @if (in_array(auth()->user()->role, ['admin', 'mod']))
                                        <form class="ajax-form" method="POST"
                                            action="{{ route('category.thread.posts.destroy', ['category' => $category, 'thread' => $thread, 'post' => $post]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error">
                                                Delete Post as Admin
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth

                            <!-- Replies Section -->
                            @include('threads.replyList')

                            <!-- Form to Post a Reply -->
                            @auth
                                @include('threads.reply')
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination links -->
        <div class="flex justify-center m-4 pagination-container">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-gray-500">No comments yet.</p>
    @endif




    </div>

</x-app-layout>
