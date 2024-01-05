<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>


    {{-- container --}}
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex flex-wrap -mx-4">

            {{-- limit category creation to admin(optional) --}}
            {{-- @if (auth()->user()->role === 'admin') --}}
                {{-- card --}}
                <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                    <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                        <figure class="px-10 pt-10">
                            <img src="{{ asset('storage/images/add_category.png') }}"
                                alt="Add New Category" class="rounded-xl" />
                        </figure>
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Add New Category</h2>
                            <p>Add New Category</p>
                            <div class="card-actions">
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add
                                    Category</a>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
            {{--  --}}

            {{-- card --}}
            <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('storage/images/manage_categories.jpg') }}" alt="Shoes" class="rounded-xl" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Manage Categories</h2>
                        <p>Manage Categories</p>
                        <div class="card-actions">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Manage
                                Categories</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}

            {{-- card --}}
            <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('storage/images/report.png') }}"  class="rounded-xl"/>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Manage Reports</h2>
                        <p>Manage Reports</p>
                        <div class="card-actions">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">Manage Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}

            {{-- card --}}
            <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('storage/images/manage_badges.png') }}" alt="Shoes"
                            class="rounded-xl" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Manage user badges</h2>
                        <p>Manage User Badges</p>
                        <div class="card-actions">
                            <a href="{{ route('admin.badges.index') }}" class="btn btn-primary">Manage
                                Badges</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}

            @if (auth()->user()->role === 'admin')
                {{-- card --}}
                <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                    <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                        <figure class="px-10 pt-10">
                            <img src="{{ asset('storage/images/manage_roles.png') }}"
                                alt="Shoes" class="rounded-xl" />
                        </figure>
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Manage Administration</h2>
                            <p>Manage Administrators and moderators.</p>
                            <div class="card-actions">
                                <a href="{{ route('admin.roles.assign') }}" class="btn btn-primary">Manage
                                    authorities</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  --}}
            @endif

                {{-- card --}}
                <div class="w-full sm:w-1/2 lg:w-1/4 px-4 my-8 mb-8">
                    <div class="card card-compact bg-neutral shadow-xl hover:scale-105 transition duration-500">
                        <figure class="px-10 pt-10">
                            <img src="{{ asset('storage/images/manage_users.png') }}" alt="Shoes"
                                class="rounded-xl" />
                        </figure>
                        <div class="card-body items-center text-center">
                            <h2 class="card-title">Manage Users</h2>
                            <p>Manage Users</p>
                            <div class="card-actions">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage
                                    Users</a>
                            </div>
                        </div>
                    </div>
                </div>
    
                {{--  --}}
        </div>
    </div>
    {{--  --}}


</x-app-layout>
