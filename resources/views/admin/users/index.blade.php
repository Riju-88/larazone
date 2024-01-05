<x-app-layout>
    <x-slot name="header" class="mt-4">
        {{-- success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        <h2 class="font-semibold text-xl text-center mt-16">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>


    <div class="flex flex-wrap items-center justify-center container">
        @foreach ($users as $user)
            <!-- Use a flex container with a gradient background and wrap the cards -->

            {{-- if user has image --}}
            <!-- Use a card component with a glass effect for each user -->
            <div class="card shadow-lg bg-neutral m-4 mt-10  p-2 flex flex-col items-center justify-center">

                <div class="indicator">
                    <span
                        class="indicator-item indicator-center  badge  bg-slate-800 border-none h-24 w-24 rounded-full">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <a href="{{ route('view_user.show', $user->id) }}">
                                    <img src="{{ asset('storage/' . ($user->profile_image ?? 'default/user.svg')) }}"
                                        alt="User Image" class=" ">
                                </a>
                            </div>
                        </div>

                    </span>
                </div>
                <div class="card-body flex items-center">
                    <a href="{{ route('view_user.show', $user->id) }}">
                        <div class="flex flex-col text-center items-center mt-4">

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
                                                        : 'bg-primary'))))) }} m-2">
                                {{ $user->badge }}</div>

                        </div>
                        <p class="text-center text-2xl font-bold"> {{ $user->name }}</p>
                        <p class="text-center"> {{ $user->email }}</p>

                        <p class="text-center"><strong>User ID:</strong> {{ $user->id }}</p>
                    </a>
                </div>
                <div class="flex text-center items-center gap-3 m-auto mb-2">
                    <div class="text-success btn btn-secondary rounded-full"><strong>
                            <span class="material-symbols-outlined">
                                shift
                            </span>
                        </strong> {{ $user->upvotes }}</div>|
                    <div class="text-error btn btn-secondary rounded-full"><strong><span
                                class="material-symbols-outlined rotate-180">
                                shift
                            </span></strong> {{ $user->downvotes }}</div>
                </div>

                {{-- delete button --}}



                {{-- Delete Post --}}
                <!-- Open the modal using ID.showModal() method -->
                @if (in_array($user->role, ['admin', 'mod']))
                    <button class="btn btn-disabled rounded-none rounded-b-lg">
                    </button>
                @else
                    <button class="btn w-full btn-secondary rounded-none rounded-b-lg"
                        onclick="{{ 'user_modal' . $user->id }}.showModal()" title="Delete"><span
                            class="material-symbols-outlined text-error text-3xl">
                            delete
                        </span>
                    </button>

                @endif
                <dialog id="{{ 'user_modal' . $user->id }}" class="modal transition-none">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg text-center">Delete this user account?</h3>
                        <div>
                            <p><strong>User ID:</strong> {{ $user->id }}</p>
                            <p><strong>User Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                        <p class="text-warning">(Note: This will delete the user account from the database. This action
                            cannot be undone)</p>
                        <div class="modal-action">
                            <form action="{{ route('admin.destroyUser', $user->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-error btn-block">Delete</button>
                            </form>
                            <button class="btn" onclick="{{ 'user_modal' . $user->id }}.close()">Close</button>
                        </div>
                    </div>
                </dialog>


                {{--  --}}

            </div>
        @endforeach
    </div>
</x-app-layout>
