<x-app-layout>
    <x-slot name="header">

    </x-slot>

    {{-- stat --}}
    <div class="w-full max-w-7xl mx-auto mt-20">
        <div class="stats shadow stats-vertical lg:stats-horizontal grid lg:flex-row">

            <div class="stat place-items-center">
                <div class="stat-figure text-secondary">
                    <div class="avatar">
                        <div class="w-24 rounded-xl">
                            <img src="{{ asset('storage/' . ($user->profile_image ?? 'default/user.svg')) }}" />
                        </div>
                    </div>
                </div>
                <div class="stat-value">{{ $user->name }}</div>
                <div class="stat-title"><div
                    class="badge {{ $user->badge === 'user'
                        ? 'bg-user'
                        : ($user->badge === 'mod'
                            ? 'bg-mod'
                            : ($user->badge === 'new user'
                                ? 'bg-newUser'
                                : ($user->badge === 'pro'
                                    ? 'bg-pro'
                                    : ($user->badge === 'negative influencer'
                                        ? 'bg-troll'
                                        : 'bg-primary')))) }}">
                    {{ $user->badge }}
                </div></div>
                <div class="stat-desc text-secondary">{{ $user->email }}</div>
                <div class="stat-desc text-gray-400">Joined {{ $user->created_at->diffForHumans() }}</div>
            </div>

            <div class="stat place-items-center">
                <div class="stat-figure text-primary">
                    <span class="material-symbols-outlined text-primary text-5xl material-symbols-outlined-thin">
                        thumbs_up_down
                        </span>
                </div>
                <div class="stat-title">Total up and down votes</div>
                <div class="stat-value flex">
                    <div>
                    <span class="material-symbols-outlined material-symbols-filled text-success">
                        shift
                    </span> {{ $user->posts()->sum('upvotes') }}
                </div>
                <div class="flex w-full">
                    
                    <div class="divider divider-horizontal"></div>
                
                  </div>
                    <div>
                   <span class="material-symbols-outlined material-symbols-filled text-error rotate-180">
                        shift
                    </span>{{ $user->posts()->sum('downvotes') }}
                </div>
                </div>
                <div class="stat-desc">---</div>
            </div>

            <div class="stat place-items-center">
                <div class="stat-figure text-secondary">
                    <span class="material-symbols-outlined text-primary text-5xl material-symbols-outlined-thin">
                        forum
                        </span>
                </div>
                <div class="stat-title">Total threads and posts</div>
                <div class="stat-value text-secondary flex">
                   
                    <figure class="text-center">{{ $user->threads()->count() }} 
                    <figcaption class="text-gray-400 text-xs">Threads</figcaption>
                </figure>
                    <div class="flex w-full">
                    
                        <div class="divider divider-horizontal"></div>
                    
                      </div>
                       <figure class="text-center">
                    {{ $user->posts()->count() }}
                    <figcaption class="text-gray-400 text-xs">Posts</figcaption>
                </div>
                <div class="stat-desc">---</div>
            </div>


        </div>
    </div>
    {{-- end stat --}}

    <div class="mx-4">
    <div class="text-2xl mb-4 mx-2">Threads: </div>

    @foreach ($threads->reverse() as $thread)
        <div
            class="card p-4 bg-neutral max-w-5xl mx-auto shadow-md rounded-3xl hover:scale-105 hover:shadow-xl transition duration-300 ease-in-out m-4">
            <h4 class="text-lg font-medium leading-6">
                {{ $thread->user->name }}
            </h4>
            <a href="{{ route('threads.show', ['category' => $thread->category, 'thread' => $thread]) }}"
                class="text-lg font-semibold mix-blend-diff hover:underline">{{ $thread->title }}</a>

            <div class="mt-2 overflow-hidden overflow-ellipsis h-20">{!! $thread->content !!}</div>
            <p class="mt-2 text-sm text-gray-500">(Category: {{ $thread->category->name }})</p>
        </div>
    @endforeach

    <div class="flex justify-center m-4 pagination-container">
        {{ $threads->links() }}
    </div>
    <div class="text-2xl mb-4 mx-2">Posts: </div>

    @foreach ($posts->reverse() as $post)
        <div
            class="card p-4 bg-neutral max-w-5xl mx-auto shadow-md rounded-3xl hover:scale-105 hover:shadow-xl transition duration-300 ease-in-out m-4">
            <h4 class="text-lg font-medium leading-6">
                {{ $post->user->name }}
            </h4>

            <p class="text-sm text-gray-600">
                {{ $post->created_at->diffForHumans() }}
            </p>
            <div class="mt-2 overflow-hidden overflow-ellipsis h-20">
                <a
                    href="{{ route('threads.show', ['category' => $post->category_id, 'thread' => $post->thread_id]) . '#post-' . $post->id }}" class="hover:underline">

                    {!! $post->content !!}
                </a>
            </div>
        </div>
    @endforeach

    <div class="flex justify-center m-4 pagination-container">
        {{ $posts->links() }}
    </div>
    </div>
</x-app-layout>
