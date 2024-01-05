
{{-- Delete Post --}}
<!-- Open the modal using ID.showModal() method -->
<button class="text-error flex items-center" onclick="{{ 'modal' . $post->id }}.showModal()"><span class="material-symbols-outlined" title="delete">
    delete
    </span></button>

<dialog id="{{ 'modal' . $post->id }}" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Delete this post?</h3>
        <p class="p-2 break-words overflow-hidden h-[4.5em]">{!! $post->content !!}</p>

        <div class="modal-action">
            <form class="ajax-form" method="POST"
                action="{{ route('category.thread.posts.destroy', ['category' => $category, 'thread' => $thread, 'post' => $post]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Delete Post</button>
            </form>
            <button class="btn" onclick="{{ 'modal' . $post->id }}.close()">Close</button>
        </div>
    </div>
</dialog>


{{--  --}}
