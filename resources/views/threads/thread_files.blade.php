@if (!empty($thread->files))
<div>
    <h2>Attached Files:</h2>
    <ul>
        {{-- Display images --}}
        @foreach ($thread->files as $filePath)
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
        @foreach ($thread->files as $filePath)
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
