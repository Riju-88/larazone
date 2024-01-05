@if (!empty($post->files))
<div class="mt-4 space-y-2">
    <h2 class="font-bold">Attached Files:</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        {{-- Display images --}}
        @foreach ($post->files as $filePath)
            @php
                $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            @endphp
            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $filePath) }}" alt="Attached Image"
                        class="object-contain rounded-lg w-24">
                </div>
            @endif
        @endforeach
    </div>

   {{-- Display other files (non-images) --}}
<ul class="list-disc pl-4">
    @foreach ($post->files as $filePath)
        @php
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        @endphp
        @if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
            <li class="m-1 overflow-auto">
                <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                    class="text-blue-500 link hover:text-blue-700 break-all">{{ $fileName . '.' . $extension }}</a>
            </li>
        @endif
    @endforeach
</ul>



</div>
@endif
