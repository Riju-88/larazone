{{-- thread --}}
<div class="p-6 bg-neutral rounded-2xl shadow-md max-w-5xl mx-auto mt-16">
    <h2 class="font-semibold text-2xl leading-tight my-2">
        <span class="text-normal text-sm text-gray-400">
            <a href="{{ route('category.threads.index', ['category' => $thread->category]) }}"
                
                class="hover:underline">
                {{ $thread->category->name }} &gt; </a>
            </span>
            {{ $thread->title }}
    </h2>

    {{-- User Info --}}
    <div class="flex space-x-4 items-start">
        <img src="{{ asset('storage/' . ($thread->user->profile_image ?? 'default/user.svg')) }}" alt="User Image"
            class="w-12 h-12 rounded-full">
        <div class="flex-1 space-y-2">
            <div class="flex justify-between items-center">
                <a class="text-xl font-semibold hover:underline" href="{{ route('view_user.show', $thread->user->id) }}">{{ $thread->user->name }}</a>
                <p class=" mix-blend-difference">{{ $thread->created_at->diffForHumans() }}
                </p>

            </div>
            <div
                class="badge {{ $thread->user->badge === 'user'
                    ? 'bg-user'
                    : ($thread->user->badge === 'admin'
                        ? 'bg-admin'
                    : ($thread->user->badge === 'mod'
                        ? 'bg-mod'
                        : ($thread->user->badge === 'new user'
                            ? 'bg-newUser'
                            : ($thread->user->badge === 'pro'
                                ? 'bg-pro'
                                : ($thread->user->badge === 'negative influencer'
                                    ? 'bg-troll'
                                    : 'bg-primary'))))) }}">
                {{ $thread->user->badge }}
            </div>
        </div>
    </div>

    {{-- Thread Content --}}
    <div class="mt-4 break-words text-wrap">{!! $thread->content !!}</div>

    {{-- Attached Files --}}
    @include('threads.thread_files')

    @auth
        @if (auth()->user()->id === $thread->user_id)
            <a href="{{ route('threads.edit', ['category' => $category, 'thread' => $thread]) }}"
                class="mt-4"><span class="material-symbols-outlined text-primary">Edit</span></a>


            {{-- Delete thread --}}
            @include('threads.delete_thread')
        @endif

        <div class="flex flex-col w-full">
                               
            <div class="divider"></div> 
           
          </div>
        {{-- Report thread --}}
        @include('threads.report_thread')

        {{-- Delete thread as admin --}}
        @if (in_array(auth()->user()->role, ['admin', 'mod']))
        <form class="ajax-form" method="POST"
        action="{{ route('threads.thread.destroy', ['thread' => $thread]) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="btn btn-error">
                Delete Thread as Admin
            </button>
        </form>
    @endif

    @endauth
</div>
<div>
    {{-- Additional content --}}
</div>
