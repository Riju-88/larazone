<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl  font-bold mt-24 text-gray-400">Categories</h1>
    </x-slot>

    <div class="min-h-screen">
        <div class="join m-2 mx-6">
            <a class="btn btn-primary join-item rounded-full {{ !request()->has('filter') ? ' btn-primary' : 'btn-outline' }}" href="{{ route('categories.index') }}">All</a>
            <form action="{{ route('categories.index') }}" method="get">
                <input type="hidden" name="filter" value="following">
                <button type="submit" class="btn btn-primary {{ request('filter') === 'following' ? ' btn-primary' : 'btn-outline' }} join-item rounded-full">Following</button>
            </form>
        </div>
        <div class="container mx-auto my-8 ">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($categories as $index => $category)
                    <div class="rounded-xl p-4 bg-neutral mx-2 rounded-xl text-wrap">
                        <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-300 text-wrap break-words">{{ $category->description }}</p>

                        <div class="flex flex-wrap items-center">


                            <a href="{{ route('category.threads.create', ['category' => $category]) }}"
                                class="mx-auto mt-4 btn btn-outline btn-primary rounded-full w-full"
                                title="Add Thread">
                                {{-- <span class="material-symbols-outlined material-symbols-filled text-4xl">
                                add_circle
                            </span> --}}
                                New Thread
                            </a>
                            <div class="grid grid-cols-2 w-full  gap-4">
                                <a href="{{ route('category.threads.index', ['category' => $category]) }}"
                                    class="text-primary mt-4 btn btn-outline btn-primary rounded-full row-start "
                                    title="View Threads">
                                    {{-- <span class="material-symbols-outlined text-4xl">
                                article
                            </span> --}}
                                    View Threads
                                </a>

                                <form method="POST"
                                    action="{{ auth()->user()->subscriptions()->where('category_id', $category->id)->exists()
                                        ? route('categories.unsubscribe', ['categoryId' => $category->id])
                                        : route('categories.subscribe', ['categoryId' => $category->id]) }}"
                                    class="ajax-form w-full">
                                    @csrf
                                    @if (auth()->user()->subscriptions()->where('category_id', $category->id)->exists())
                                        <button type="submit"
                                        class="flex align-center  mt-4 btn btn-primary rounded-full btn-block">
                                            {{-- <span
                                        class="material-symbols-outlined material-symbols-filled  text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-red-500 text-5xl"
                                        title="Unfollow">
                                        star
                                    </span> --}}
                                            Following
                                        </button>
                                    @else
                                        <button type="submit"
                                        class="flex align-center mt-4 btn btn-outline btn-primary btn-block rounded-full"
                                            title="Follow">
                                            {{-- <span class="material-symbols-outlined material-symbols-outlined-thin text-5xl">
                                        star
                                    </span> --}}
                                            Follow
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>




</x-app-layout>
