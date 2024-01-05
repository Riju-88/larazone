<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 mt-24 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>
    <div class="min-h-screen"> 
    <div class="overflow-x-auto">
        <table class="list-disc pl-6 w-full table-auto table table-hover table-xs">
            <thead>
                <tr class="bg-lime text-white">
                    <th class="py-3 px-6 text-left font-bold text-lg">Name</th>
                    <th class="py-3 px-6 text-left font-bold text-lg">Description</th>
                    <th class="py-3 px-6 text-center font-bold text-lg">Action</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-indigo-600 transition duration-200">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold text-lg">{{ $category->name }}</td>
                        <td class="py-3 px-6 text-left max-w-md truncate">{{ $category->description }}</td>
                        <td class="flex flex-row justify-center items-center gap-2 py-3 px-6 text-center">
                           
                            {{-- edit category --}}
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-info hover:scale-105">Edit</a>
                            <!-- Open the modal using ID.showModal() method -->
                            {{-- delete category --}}
                            <button class="btn btn-error"
                                onclick="{{ 'modal' . $category->id }}.showModal()">Delete</button>

                            <dialog id="{{ 'modal' . $category->id }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg">Delete this category?</h3>
                                    <p class="p-2 break-words overflow-hidden h-[4.5em] text-xl font-bold">{{ $category->name }}</p>
                                    <p class="p-2 break-words overflow-hidden h-[4.5em]">{{ $category->description }}</p>

                                    <div class="modal-action">
                                        <form method="POST"
                                            action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error">Delete Category</button>
                                        </form>
                                        <button class="btn"
                                            onclick="{{ 'modal' . $category->id }}.close()">Close</button>
                                    </div>
                                </div>
                            </dialog>


                            {{--  --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>




</x-app-layout>
