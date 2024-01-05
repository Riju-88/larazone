<nav x-data="{ open: false }"
    class="fixed bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 w-full z-10 transition-transform duration-300 ease-in-out">


    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @auth
                    @if (in_array(auth()->user()->role, ['admin', 'mod']))
                        <!-- Add admin/mod links here -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="ajax-link">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endauth
                {{-- link for categories --}}

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="ajax-link">
                        {{ __('Categories') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('about.index')" :active="request()->routeIs('about.index')" class="ajax-link">
                        {{ __('About') }}
                    </x-nav-link>
                </div>




            </div>

            <!-- Settings Dropdown -->

            {{-- check auth --}}
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    {{-- notifications --}}
                    <!-- Open the modal using ID.showModal() method -->
                    <x-nav-link>
                        <button onclick="notifications.showModal()"><span class="material-symbols-outlined">
                                notifications
                            </span></button>
                    </x-nav-link>
                    <dialog id="notifications" class="modal">
                        <div class="modal-box scrollbar">
                            <h3 class="font-bold text-lg text-center">Notifications</h3>
                            <div class="container mx-auto p-4">
                                @if (auth()->check())
                                    @foreach (auth()->user()->notifications as $notification)
                                        <div class="alert bg-gray-800 text-sky-500 m-2">
                                            {!! $notification->data['message'] !!}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>
                    {{-- end notifications --}}

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

                                <div class="flex items-center flex-col">
                                    <div class="avatar w-8 h-8">
                                        <div class=" rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                            <img
                                                src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default/user.svg')) }}" />

                                        </div>
                                    </div>

                                    <div class="mx-2">{{ Auth::user()->name }}</div>

                                </div>


                                <div class="ml-1">
                                    {{-- <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg> --}}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form class="ajax-form" method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    {{-- else --}}
                @else
                    <div class="flex items-center flex-col sm:flex-row sm:hidden">
                        <div class="avatar">
                            <div class="rounded-full w-10 h-10">
                                <img src="{{ asset('storage/default/user.svg') }}" />

                            </div>

                        </div>
                        <div class="mx-2">Guest</div>
                    </div>
                </div>
            @endauth

        </div>
        <!-- Hamburger -->
        <div class=" inline items-center lg:hidden">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <div class="px-4">
            {{-- check auth --}}
            @auth
                {{-- user image --}}
                <div class="avatar w-8 h-8">
                    <div class=" rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default/user.svg')) }}" />

                    </div>
                </div>

                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

                {{-- else auth --}}
            @else
                {{-- user image --}}
                <div class="avatar w-8 h-8">
                    <div class=" rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="{{ asset('storage/' . 'default/user.svg') }}" />

                    </div>
                </div>

                <div class="font-medium text-base text-gray-800 dark:text-gray-200">Guest</div>


                <!-- display content for guests here -->
            @endauth
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">


            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endauth


                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Authentication -->
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                              this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

