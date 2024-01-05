
{{-- Delete reply --}}
<!-- Open the modal using ID.showModal() method -->
@auth
@if (auth()->user()->id === $reply->user_id)
<button class="text-error" onclick="{{ 'reply_modal' . $reply->id }}.showModal()"><span class="material-symbols-outlined">
    delete
    </span></button>

<dialog id="{{ 'reply_modal' . $reply->id }}" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Delete this reply?</h3>
       

        <div class="modal-action">
            <form class="ajax-form" method="POST"
                action="{{ route('category.thread.posts.replies.destroy', ['category' => $category, 'thread' => $thread, 'post' => $post, 'reply' => $reply]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Delete Reply</button>
            </form>
            <button class="btn" onclick="{{ 'reply_modal' . $reply->id }}.close()">Close</button>
        </div>
    </div>
</dialog>
@endif
@endauth
{{--  --}}
