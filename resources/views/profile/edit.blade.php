<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- stat --}}
    <div class="w-full max-w-7xl mx-auto mt-8">
        <div class="stats shadow stats-vertical lg:stats-horizontal grid lg:flex-row">

            <div class="stat place-items-center">
                <div class="stat-figure text-secondary">
                    <div class="avatar">
                        <div class="w-24 rounded-xl">
                            <img src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default/user.svg')) }}" />
                        </div>
                    </div>
                </div>
                <div class="stat-value">{{ Auth::user()->name }}</div>
                <div class="stat-title">
                    <div
                        class="badge {{ Auth::user()->badge === 'user'
                            ? 'bg-user'
                            : (Auth::user()->badge === 'mod'
                                ? 'bg-mod'
                                : (Auth::user()->badge === 'new user'
                                    ? 'bg-newUser'
                                    : (Auth::user()->badge === 'pro'
                                        ? 'bg-pro'
                                        : (Auth::user()->badge === 'negative influencer'
                                            ? 'bg-troll'
                                            : 'bg-primary')))) }}">
                        {{ Auth::user()->badge }}
                    </div>
                </div>
                <div class="stat-desc text-secondary">{{ Auth::user()->email }}</div>
                <div class="stat-desc text-gray-400">Joined {{ Auth::user()->created_at->diffForHumans() }}</div>
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
                        </span> {{ Auth::user()->posts()->sum('upvotes') }}
                    </div>
                    <div class="flex w-full">

                        <div class="divider divider-horizontal"></div>

                    </div>
                    <div>
                        <span class="material-symbols-outlined material-symbols-filled text-error rotate-180">
                            shift
                        </span>{{ Auth::user()->posts()->sum('downvotes') }}
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
                    <figure class="text-center">
                        {{ Auth::user()->threads()->count() }}
                        <figcaption class="text-gray-400 text-xs">Threads</figcaption>
                    </figure>


                    <div class="flex w-full">

                        <div class="divider divider-horizontal"></div>

                    </div>
                    <figure class="text-center">
                        {{ Auth::user()->posts()->count() }}
                        <figcaption class="text-gray-400 text-xs">Posts</figcaption>

                </div>
                <div class="stat-desc">---</div>
            </div>


        </div>
    </div>
    {{-- end stat --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
