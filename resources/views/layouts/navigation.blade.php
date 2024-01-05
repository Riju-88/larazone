<div x-data="{ isOpen: false }">
    <nav
        class=" px-4 py-2 flex justify-between items-center fixed bg-white dark:bg-neutral border-b border-gray-100 dark:border-gray-700 w-full z-10 transition-transform duration-300 ease-in-out">
        <a class="text-3xl font-bold leading-none" href="{{ route('dashboard') }}">

            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />

        </a>
        {{-- search attempt for small screen --}}

        <!-- Open the modal using ID.showModal() method -->
        <!-- Open the modal using ID.showModal() method -->
        <button onclick="search_modal.showModal()" class="ml-auto mr-2 flex items-center lg:hidden">
            <span class="material-symbols-outlined">
                search
            </span>
        </button>
        <dialog id="search_modal" class="modal modal-top">
            <div class="modal-box py-4">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="font-bold text-lg my-2">Search threads and posts</h3>


                <form action="{{ route('search.index') }}" method="get">
                    <div class="flex flex-nowrap items-center justify-center mx-auto my-2">

                        <input name="search" type="search"
                            class=" input input-bordered rounded-l-full bg-transparent border-primary  my-4 w-3/4" placeholder="Search" />

                        <button class="btn my-4 rounded-r-full bg-transparent border-primary" type="submit"><span
                                class="material-symbols-outlined">
                                search
                            </span>
                        </button>
                    </div>

                    <select name="filter" class="select select-bordered join-item border-primary bg-transparent my-2"
                        title="filter">
                        <option class="text-white p-2 text-sm" value="" selected>All</option>
                        <option class="text-white p-2 text-sm" value="Thread">Thread</option>
                        <option class="text-white p-2 text-sm" value="Post">Post</option>
                    </select>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button></button>
            </form>
        </dialog>
        {{-- end search attempt for small screen --}}

        {{-- notification attempt for small screen --}}
        @auth

            <button onclick="notifications_mobile.showModal()" class=" flex items-center lg:hidden"><span
                    class="material-symbols-outlined">
                    notifications
                </span></button>
            <dialog id="notifications_mobile" class="modal modal-top">
                <div class="modal-box">
                    <h3 class="font-bold text-lg text-center">Notifications</h3>
                    <div class="container mx-auto p-2 max-h-80">
                        @if (auth()->check())
                            @foreach (auth()->user()->notifications as $notification)
                                <div class="alert bg-neutral text-primary m-2">
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
        @endauth
        {{-- end notification attempt for small screen --}}
        <div class="lg:hidden">

            <button class="navbar-burger flex items-center text-white p-3" id="navbarBurger" @click="isOpen = !isOpen">
                <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Mobile menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </button>
        </div>
        <ul
            class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Home') }}
                </x-nav-link>
            </li>

            @auth
                @if (in_array(auth()->user()->role, ['admin', 'mod']))
                    <li class="text-primary">
                        |
                    </li>
                    <li>

                        <!-- Add admin/mod links here -->

                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="ajax-link">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>

                    </li>
                @endif

                <li class="text-primary">
                    |
                </li>
                <li>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="ajax-link">
                        {{ __('Categories') }}
                    </x-nav-link>
                </li>
            @endauth
            <li class="text-primary">
                |
            </li>
            <li><a class="text-sm text-gray-400 hover:text-gray-500" href="{{ route('about.index') }}">About</a></li>

            <li>
                {{-- <form action="{{ route('search.index') }}" method="get">
                <input type="text" name="search" placeholder="Search" class="bg-transparent rounded-full border-primary">
               <button type="submit" class="flex">Search</button>
            </form> --}}


                {{--  --}}
                <form action="{{ route('search.index') }}" method="get">
                    <div class="join hidden md:flex">

                        <div>
                            <div>
                                <input name="search"
                                    class="input input-bordered join-item  rounded-l-full bg-transparent border-primary"
                                    placeholder="Search" />
                            </div>
                        </div>
                        <select name="filter" class="select select-bordered join-item border-primary bg-transparent"
                            title="filter">
                            <option class="text-white p-2" value="" selected>All</option>
                            <option class="text-white p-2" value="Thread">Thread</option>
                            <option class="text-white p-2" value="Post">Post</option>
                        </select>

                        <div>

                            <button class="btn join-item rounded-r-full bg-transparent border-primary"
                                type="submit"><span class="material-symbols-outlined">
                                    search
                                </span></button>
                        </div>

                    </div>
                </form>
                {{--  --}}
            </li>
        </ul>
        @guest
            <a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-gray-50 hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
                href="{{ route('login') }}">Sign In</a>
            <a class="hidden lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200"
                href="{{ route('register') }}">Sign up</a>


        @endguest

        {{-- notifications and user profile --}}
        @auth
            <div class="hidden lg:flex sm:items-center sm:ml-6">
                {{-- notifications --}}
                <!-- Open the modal using ID.showModal() method -->
                <x-nav-link>
                    <button onclick="notifications.showModal()">
                        <span class="material-symbols-outlined material-symbols-filled">
                            notifications
                        </span>
                    </button>
                </x-nav-link>
                <dialog id="notifications" class="modal">
                    <div class="modal-box scrollbar  translate-x-3/4">
                        <h3 class="font-bold text-lg text-center">Notifications</h3>
                        <div class="container mx-auto p-4">
                            @if (auth()->check())
                                @foreach (auth()->user()->notifications as $notification)
                                    <div class="p-2 bg-neutral  m-2 text-wrap rounded-xl">
                                        <p class="text-primary">
                                            {!! $notification->data['message'] !!}
                                        </p>
                                        <div class="grid justify-items-end">
                                            <p class="mx-2 text-gray-400">{{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
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
                            class="inline-flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-neutral hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

                            <div class="flex items-center flex-col">
                                <div class="avatar w-8 h-8">
                                    <div class=" rounded-full ring ring-success ring-offset-base-100 ring-offset-2">
                                        <img
                                            src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default/user.svg')) }}" />

                                    </div>
                                </div>

                                <div class="mx-2 mt-2">{{ Auth::user()->name }}</div>

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

                        <!-- logout -->
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
            </div>
        @endauth
        {{-- end notifications and user profile --}}
    </nav>
    <div class="navbar-menu relative z-50 -translate-x-full transition-translate duration-300 ease-in-out lg:hidden"
        id="navbarMenu" :class="{ '-translate-x-full': !isOpen }">
        <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25" @click="isOpen = false"></div>
        <nav
            class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white dark:bg-gray-800 border-r overflow-y-auto  transition-translate duration-300 ease-in-out">
            <div class="flex items-center mb-8">
                <a class="text-3xl mr-auto font-bold leading-none" href="{{ route('dashboard') }}">

                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />

                </a>
                <button class="navbar-close" @click="isOpen = false">
                    <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div>
                <ul>
                    @auth

                        <li class="mb-1">
                            <div class="flex items-center flex-col">
                                <div class="avatar w-16 h-16">

                                    <div class=" rounded-full ring ring-success ring-offset-base-100 ring-offset-2">
                                        <img
                                            src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default/user.svg')) }}" />
                                    </div>
                                </div>
                                <div class="m-2">
                                    <div
                                        class="badge {{ Auth::user()->badge === 'user'
                                            ? 'bg-user'
                                            : (Auth::user()->badge === 'admin'
                                                ? 'bg-admin'
                                                : (Auth::user()->badge === 'mod'
                                                    ? 'bg-mod'
                                                    : (Auth::user()->badge === 'new user'
                                                        ? 'bg-newUser'
                                                        : (Auth::user()->badge === 'pro'
                                                            ? 'bg-pro'
                                                            : (Auth::user()->badge === 'negative influencer'
                                                                ? 'bg-troll'
                                                                : 'bg-primary'))))) }}">
                                        {{ Auth::user()->badge }}
                                    </div>
                                </div>
                                <div class="font-bold text-lg">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>

                            <div class="flex flex-col w-full">

                                <div class="divider"></div>

                            </div>
                        </li>

                        {{-- dashboard --}}
                        <li class="mb-1">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="ajax-link block p-2 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded mb-1">
                                {{ __('Home') }}
                            </x-nav-link>
                        </li>
                        <li class="mb-1">
                            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')"
                                class="block p-2 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded">
                                {{ __('Categories') }}
                            </x-nav-link>
                        </li>

                        @if (in_array(auth()->user()->role, ['admin', 'mod']))
                            <li class="mb-1">
                                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                                    class="block p-2 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded">
                                    {{ __('Admin Dashboard') }}
                                </x-nav-link>
                            </li>
                        @endif
                    @endauth
                    <li class="mb-1">
                        <x-nav-link :href="route('about.index')" :active="request()->routeIs('about.index')"
                            class="block p-2 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded">
                            {{ __('About') }}
                        </x-nav-link>
                    </li>
                    @auth
                        <li class="mb-1">
                            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                                class="block p-2 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded">
                                {{ __('Profile') }}
                            </x-nav-link>
                        </li>
                    @endauth
                </ul>
            </div>
            <div class="mt-auto">
                @guest
                    <div class="pt-6">
                        <a class="block px-4 py-3 mb-3 leading-loose text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl"
                            href="{{ route('login') }}">Sign in</a>
                        <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl"
                            href="{{ route('register') }}">Sign up</a>
                    </div>

                @endguest
                @auth
                    <form class="ajax-form" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                this.closest('form').submit();"
                            class="block px-4 py-3 mb-3 leading-loose text-xs text-center font-semibold leading-none bg-gray-50 hover:bg-gray-100 rounded-xl text-info">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                @endauth
                <p class="my-4 text-xs text-center text-gray-400">
                    <span>Copyright © {{ now()->year }}</span>
                </p>
            </div>
        </nav>
    </div>
</div>
