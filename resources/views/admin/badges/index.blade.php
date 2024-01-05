<x-app-layout>
    <x-slot name="header">
        {{-- success message --}}
        @if (session('success'))
            <div class="alert alert-success mt-20">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-error mt-20">
                {{ session('error') }}
            </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-20">
            {{ __('Manage User Badges') }}
        </h2>
    </x-slot>

    <div class="min-h-screen">
        <form action="{{ route('admin.updateUserBadges') }}" method="post">
            @csrf
            <div class="fixed bottom-4 right-4 z-10">
                <button type="submit" class="btn btn-primary rounded-full">Update user badges</button>
            </div>
        </form>
        <div
            class="flex flex-wrap items-center justify-center p-2  container">
            @foreach ($users as $user)
                <!-- Use a flex container with a gradient background and wrap the cards -->

                {{-- if user has image --}}
                <!-- Use a card component with a glass effect for each user -->
                <div class="card shadow-lg m-4 bg-opacity-60 bg-neutral">
                    <div class="card-body flex items-center">
                        <div class="flex flex-col text-center items-center ">
                            <img src="{{ asset('storage/' . ($user->profile_image ?? 'default/user.svg')) }}"
                                alt="User Image" class="w-12 h-12 rounded-full">
                            <div
                                class="badge {{ $user->badge === 'user'
                                    ? 'bg-user'
                                    : ($user->badge === 'mod'
                                        ? 'bg-mod'
                                        : ($user->badge === 'admin'
                                            ? 'bg-admin'
                                            : ($user->badge === 'new user'
                                                ? 'bg-newUser'
                                                : ($user->badge === 'pro'
                                                    ? 'bg-pro'
                                                    : ($user->badge === 'negative influencer'
                                                        ? 'bg-troll'
                                                        : 'bg-primary'))))) }} my-2">
                                {{ $user->badge }}</div>

                        </div>
                        <div class="flex flex-col ml-4">
                            <p><strong>User ID:</strong> {{ $user->id }}</p>
                            <p><strong>User Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex text-center items-center gap-3 m-auto mb-2">
                        <div class="text-success"><strong>Upvotes:</strong> {{ $user->upvotes }}</div>|
                        <div class="text-error"><strong>Downvotes:</strong> {{ $user->downvotes }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
