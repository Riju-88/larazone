<x-app-layout>
    <x-slot name="header">
        {{-- success message --}}
        @if (session('success'))
            <div class="alert alert-success mt-24">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="font-semibold text-xl leading-tight mt-24">
            {{ __('Manage Reports') }}
        </h2>
    </x-slot>

    @forelse ($reports->reverse() as $report)
        <div id="report-{{ $report->id }}" class=" p-6 mx-4 my-8 bg-neutral shadow-xl rounded-2xl">
            {{-- <div class="grid">
                <span class="m-2">Reporter ID:</span>
                
                <div class=" bg-gray-800 p-2 border border-primary rounded-lg max-w-xl">
                    {{ $report->reporter_id }}
                </div>
            </div>


            <div class="grid">
                <span class="m-2">Reporter Name:</span>

                <div class="grid grid-flow-col">
                <div class=" bg-gray-800 p-2 border border-primary rounded-lg max-w-xl h-min">{{ $report->reporter_name }}
                </div> 
                 <div class="avatar ml-auto">
                    <div class="w-24 rounded-xl">
                        <img src="{{ asset('storage/' . ($report->reporter_image ?? 'default/user.svg')) }}" alt="profile image">
                    </div>
                    
                </div>
                </div>
            </div>
            <div class="grid">
                <span class="m-2">Reporter Email:</span>
                <div class=" bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->reporter_email }}
                </div>

                
            </div> --}}


            {{--  --}}
            <div class="grid grid-flow-col">
                <div>
                    <div class="grid">
                        <span class="m-2">Reporter ID:</span>

                        <div class=" bg-gray-800 p-2 border border-primary rounded-lg max-w-xl">
                            {{ $report->reporter_id }}
                        </div>
                    </div>

                    <div class="grid">
                        <span class="m-2">Reporter Name:</span>

                        <div class="grid grid-flow-col">
                            <div class=" bg-gray-800 p-2 border border-primary rounded-lg max-w-xl h-min">
                                {{ $report->reporter_name }}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="avatar ml-auto">
                        <div class="w-20 lg:w-32 rounded-xl">
                            <img src="{{ asset('storage/' . ($report->reporter_image ?? 'default/user.svg')) }}"
                                alt="profile image">
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}
            <div class="flex flex-col w-full">

                <div class="divider"></div>

            </div>
            {{--  --}}
            <div class="grid grid-flow-col">
                <div>
                    <div class="grid">
                        <span class="m-2"><strong>Reported User ID:</strong></span>
                        <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->creator_id }}</div>
                    </div>

                    <div class="grid">
                        <span class="m-2"><strong>Reported User Name:</strong></span>
                        <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->creator }}</div>
                    </div>
                    <div class="grid">
                        <span class="m-2"><strong>Reported User Email:</strong></span>
                        <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->creator_email }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="avatar ml-auto">
                        <div class="w-20 lg:w-32 rounded-xl">
                            <img src="{{ asset('storage/' . ($report->creator_image ?? 'default/user.svg')) }}"
                                alt="profile image">
                        </div>
                    </div>
                </div>
            </div>
            {{--  --}}

            <div class="flex flex-col w-full">

                <div class="divider"></div>

            </div>

            <div class="grid">
                <span class="m-2">Content ID:</span>
                <div class=" bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->content_id }}
                </div>
            </div>
            <div class="grid">
                <span class="m-2">Content Type:</span>
                <div class=" bg-gray-800 p-2 border border-primary rounded-lg uppercase">
                    {{ $report->content_type }}
                </div>
            </div>


            @if ($report->content_type === 'thread')
                <div class="grid">
                    <span class="m-2"><strong>Thread Title:</strong></span>
                    <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->title }}</div>
                </div>

                <div class="grid">
                    <span class="m-2"><strong>Content:</strong></span>
                    <div class="bg-gray-800 p-2 border border-primary rounded-lg break-words text-wrap overflow-hidden">{!! $report->content !!}</div>
                </div>
            @else
                <div class="grid">
                    <span class="m-2"><strong>Content:</strong></span>
                    <div class="bg-gray-800 p-2 border border-primary rounded-lg break-words text-wrap overflow-hidden">{!! $report->content !!}</div>
                </div>
            @endif

            {{-- files --}}
            {{-- Attached Files --}}
            @if (!empty($report->files))
                <div>
                    <h2>Attached Files:</h2>
                    <ul>
                        {{-- Display images --}}
                        @foreach ($report->files as $filePath)
                            @php
                                $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                            @endphp
                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
                                <img src="{{ asset('storage/' . $filePath) }}" alt="Attached Image"
                                    class="h-24 inline-block rounded-lg m-2">
                            @endif
                        @endforeach

                        {{-- Display other files (non-images) --}}
                        @foreach ($report->files as $filePath)
                            @php
                                $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                            @endphp
                            @if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
                                <div class="m-1 flex">
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                        class="text-blue-500 link hover:text-blue-700 w-auto">{{ $fileName . '.' . $extension }}</a>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- end of files --}}

            <div class="flex flex-col w-full">

                <div class="divider"></div>

            </div>

            <div class="grid">
                <span class="m-2"><strong>Reason:</strong></span>
                <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->reason }}</div>
            </div>

            <div class="grid">
                <span class="m-2"><strong>Report Status:</strong></span>
                <div class="bg-gray-800 p-2 border border-primary rounded-lg">{{ $report->status }}</div>
            </div>


            <div class="flex m-2">
                <form
                    action="{{ route('admin.reports.delete', ['report_id' => $report->id, 'id' => $report->content_id, 'type' => $report->content_type]) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error mx-2">Delete</button>
                </form>
                <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-secondary">Mark as Closed</button>
                </form>
            </div>
        </div>
        {{-- end of report --}}
    @empty

        <h2>No reports found</h2>

    @endforelse

</x-app-layout>
