@if (auth()->user()->id === $post->user_id)
<a href="{{ route('category.thread.posts.edit', ['category' => $category, 'thread' => $thread, 'post' => $post]) }}"
    class="flex items-center text-primary"><span class="material-symbols-outlined" title="edit">
        edit
        </span></a>


{{-- Delete Post --}}
@include('threads.delete_comment')


{{--  --}}

@endif