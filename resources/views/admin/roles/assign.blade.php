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
            {{ __('Manage Roles') }}
        </h2>
    </x-slot>

    @if (auth()->user()->role === 'admin')
        <div class="flex flex-wrap items-center justify-center container">
            @foreach ($users as $user)
                {{-- if user has image --}}

                <div class="card shadow-lg bg-neutral m-2 mt-10 mx-auto p-2 flex flex-col items-center justify-center">

                    <div class="indicator">
                        <span
                            class="indicator-item indicator-center  badge  bg-slate-800 border-none h-24 w-24 rounded-full">
                            <div class="avatar">
                                <div class="w-24 rounded-full">
                                    <img src="{{ asset('storage/' . ($user->profile_image ?? 'default/user.svg')) }}"
                                        alt="User Image" class=" ">
                                </div>
                            </div>

                        </span>
                        <div class="card-body">
                            <div class="flex flex-col text-center items-center justify-center">
                               
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
                                                            : 'bg-primary'))))) }} mt-6 mb-2">
                                    {{ $user->badge }}</div>

                            </div>
                            <div class="flex flex-col">
                                <p class="text-center text-2xl"><strong>{{ $user->name }}</strong> </p>
                                <p class="break-words text-center"><strong>{{ $user->email }}</strong> </p>
                                <p><strong>User ID:</strong> {{ $user->id }}</p>

                                <p><strong>Role:</strong> {{ $user->role }}</p>

                            </div>
                        </div>
                    </div>

                    <div class="flex text-center items-center gap-3 m-auto mb-2"> 
                        
                        <div class="flex items-center justify-center "><span class="material-symbols-outlined material-symbols-filled text-success" title="Upvotes">shift</span> {{ $user->upvotes }}</div>
                       
                           
                            <div class="divider divider-horizontal"></div>
                            
                          
                        <div class="flex items-center justify-center"><span class="material-symbols-outlined rotate-180 material-symbols-filled text-error" title="Downvotes">shift</span> {{ $user->downvotes }}</div>
                    </div>
                    <div class="divider"></div> 
                    <div class="flex text-center items-center mx-auto mb-2 gap-3">

                        {{--  --}}
                        <!-- Open the modal using ID.showModal() method -->
                        @if ($user->role !== 'admin')
                            <button type="submit"
                                class="btn btn-warning btn-outline btn-sm hover:scale-105 rounded-full"
                                onclick="{{ 'modal' . $user->id }}.showModal()">Transfer admin</button>
                        @endif


                        <dialog id="{{ 'modal' . $user->id }}" class="modal  transition-transform">
                            <div class=" bg-neutral rounded-xl border-rounded border-error modal-box">
                                <div class="">
                                    <h3 class="font-bold text-3xl">Transfer admin role?</h3>
                                    <p class=" text-xl text-error font-semibold">Are you sure you want to transfer admin
                                        role to
                                        <strong>{{ $user->name }}</strong>?
                                    </p>
                                    <p class=" break-words text-xl text-warning">(Note: This action cannot be undone and
                                        you will lose all admin privileges.) </p>
                                </div>

                                <div class="modal-action items-center">
                                    <form method="POST" action="{{ route('admin.assign_admin') }}"
                                        class=" flex items-center w-full justify-center gap-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit"
                                            class="btn btn-error hover:scale-105 btn-xs sm:btn-sm md:btn-md lg:btn-lg">Transfer
                                            admin
                                            role</button>

                                        <button class="btn hover:scale-105 btn-xs sm:btn-sm md:btn-md lg:btn-lg"
                                            onclick="event.preventDefault();{{ 'modal' . $user->id }}.close()">Cancel</button>
                                    </form>

                                </div>
                            </div>
                        </dialog>
                        {{--  --}}

                        {{--  --}}
                        <!-- Open the modal using ID.showModal() method -->
                        @if ($user->role !== 'admin')
                            <button type="submit"
                                class="btn {{ $user->role === 'mod' ? 'btn-error' : 'btn-success' }} hover:scale-105 rounded-full btn-sm"
                                onclick="{{ 'mod' . $user->id }}.showModal()">
                                {{ $user->role === 'mod' ? 'Revoke Mod' : 'Assign Mod' }}
                            </button>
                        @endif




                        @if ($user->role === 'mod')
                            <!-- Moderator Revoke Dialog -->
                            <dialog id="{{ 'mod' . $user->id }}" class="modal transition-transform">
                                <div class="modal-box">
                                    <h3 class="font-bold text-3xl">Revoke moderator?</h3>
                                    <p class="p-2 break-words text-xl">Revoke moderator role from
                                        <strong>{{ $user->name }}</strong>?
                                    </p>
                                    <p class="p-2 break-words text-xl text-warning">(Note: Moderators will lose all
                                        privileges and cannot access the admin panel.)</p>
                                    <div class="modal-action">
                                        <form method="POST" action="{{ route('admin.assignMod') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-error hover:scale-105">Revoke
                                                Mod</button>
                                        </form>
                                        <button class="btn hover:scale-105"
                                            onclick="{{ 'mod' . $user->id }}.close()">Cancel</button>
                                    </div>
                                </div>
                            </dialog>
                        @else
                            <!-- Moderator Assign/Revoke Dialog -->
                            <dialog id="{{ 'mod' . $user->id }}" class="modal transition-transform">
                                <div class="modal-box">
                                    <h3 class="font-bold text-3xl">Assign moderator?</h3>
                                    <p class="p-2 break-words text-xl">Assign moderator role to
                                        <strong>{{ $user->name }}</strong>?
                                    </p>
                                    <p class="p-2 break-words text-xl text-warning">(Note: Moderators will gain multiple
                                        privileges and can access certain features of the admin panel.)</p>
                                    <div class="modal-action">
                                        <form method="POST" action="{{ route('admin.assignMod') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-info hover:scale-105">Assign
                                                Mod</button>
                                        </form>
                                        <button class="btn hover:scale-105"
                                            onclick="{{ 'mod' . $user->id }}.close()">Cancel</button>
                                    </div>
                                </div>
                            </dialog>
                        @endif

                        {{--  --}}
                    </div>
               
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
