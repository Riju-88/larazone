<x-app-layout>
    <x-slot name="header" class="">
        <h1>
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center text-3xl font-bold mt-16">
                <span class="mx-4 p-1">
                    <x-application-logo class="h-9 w-auto " />
                </span>
                {{ config('app.name') }}
            </a>
        </h1>
    </x-slot>

    {{-- feed --}}
    <div>
        <!-- Recent Threads Section -->
        <div class="mt-8 mx-4">
            <h2 class="text-xl font-semibold mb-4 text-gray-400">Recent Threads</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($recentThreads as $thread)
                    <div class="bg-neutral rounded-xl p-6">
                        <div class=" h-48 overflow-hidden">
                            <a href="{{ route('threads.show', ['category' => $thread->category, 'thread' => $thread]) }}"
                                class="text-lg font-semibold text-primary hover:underline">{{ $thread->title }}</a>
                            <div class="mt-2 overflow-hidden overflow-ellipsis">{!! $thread->content !!}</div>
                            <p class="mt-2 text-sm text-gray-500">(Category: {{ $thread->category->name }})</p>
                        </div>
                    </div>
                @empty
                    <p>No recent threads.</p>
                @endforelse
            </div>
        </div>

        {{-- subscription feed --}}
        <div class="mx-4">
            @if ($subbedCategories->count() > 0)
                <div class="container mx-auto my-8">
                    <h2 class="text-xl font-semibold mb-4 mx-4 text-gray-400">Following Categories</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- update_at wont work as its not from the subscriptions table --}}
                        @foreach ($subbedCategories as $category)
                            <div class="rounded-xl p-4 bg-neutral">
                                <h3 class="text-xl font-semibold mb-4">{{ $category->name }}</h3>
                                <p>{{ $category->description }}</p>

                                {{-- Push customObject only around the "View Threads" link --}}
                                @push('customObject')
                                    <?php
                                    // Your logic to create or fetch the custom object
                                    $customObject = new stdClass(); // Assuming you're using an object
                                    $customObject->id = $category->category_id;
                                    ?>
                                @endpush
                                <div class="flex flex-wrap items-center">
                                    <a href="{{ route('category.threads.create', ['category' => $customObject->id]) }}"
                                        class="text-success mx-auto mt-4 btn btn-outline btn-primary rounded-full w-full"
                                        title="Add Thread">Add Thread</a>

                                    <div class="grid grid-cols-2 w-full  gap-4">
                                        <a href="{{ route('category.threads.index', ['category' => $customObject->id]) }}"
                                            class="text-primary mt-4 btn btn-outline btn-primary rounded-full row-start "
                                            title="View Threads">
                                            View Threads
                                        </a>
                                        {{-- Access $customObject only around the "View Threads" link --}}
                                        @stack('customObject')
                                        <form method="POST"
                                            action="{{ auth()->user()->subscriptions()->where('category_id', $category->category_id)->exists()
                                                ? route('categories.unsubscribe', ['categoryId' => $category->category_id])
                                                : route('categories.subscribe', ['categoryId' => $category->category_id]) }}"
                                            class="ajax-form w-full">
                                            @csrf
                                            @if (auth()->user()->subscriptions()->where('category_id', $category->category_id)->exists())
                                                <button type="submit"
                                                    class="flex align-center  mt-4 btn btn-primary rounded-full btn-block"
                                                    title="Following">Following</button>
                                            @else
                                                <button type="submit"
                                                    class="flex align-center mt-4 btn btn-outline btn-primary btn-block rounded-full"
                                                    title="Follow">Follow</button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        {{-- end subscription feed --}}

        <!-- Additional Text Section -->
        <div class="bg-gradient-to-b from-base-100 to-gray-800 w-full p-6 mt-8"></div>
        <div class=" mx-auto bg-gray-800 text-white p-8 w-full ">
            <div class=" mx-auto text-center w-full">
                <p class="text-lg font-semibold mb-4">
                    This forum offers a wide range of categories to suit your interests and needs. If you don't find a
                    category that matches your topic, you can request a new one in the "Requests" Category.
                </p>
                <div class="flex justify-center">
                    <a href="{{ route('categories.index') }}" class="btn btn-primary rounded-full">Explore
                        Categories</a>
                </div>
                <!-- Admin/Mod Links -->
                @if (in_array(auth()->user()->role, ['admin', 'mod']))
                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                            Admin Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
