
{{-- Delete thread --}}
<!-- Open the modal using ID.showModal() method -->
<button class="text-error flex " onclick="{{ 'thread_modal' . $thread->id }}.showModal()"><span class="material-symbols-outlined  text-3xl">
    delete
    </span></button>

<dialog id="{{ 'thread_modal' . $thread->id }}" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Delete this thread?</h3>
        <p class="p-2 break-words overflow-hidden h-[4.5em]">{!! $thread->content !!}</p>

        <div class="modal-action">
            <form class="ajax-form" method="POST"
                action="{{ route('threads.thread.destroy', ['thread' => $thread]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Delete Thread</button>
            </form>
            <button class="btn" onclick="{{ 'thread_modal' . $thread->id }}.close()">Close</button>
        </div>
    </div>
</dialog>


{{--  --}}
