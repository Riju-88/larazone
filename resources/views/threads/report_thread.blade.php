@if (auth()->user()->id != $thread->user_id)
{{-- Report Button --}}
<button class="flex text-warning"
    onclick="{{ 'reportThread' . $thread->id }}.showModal()" title="Report">
    <span class="material-symbols-outlined text-3xl">
        report
        </span>
    </button>

{{-- Report Modal --}}
<dialog id="{{ 'reportThread' . $thread->id }}" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Report this thread?</h3>

        <div class="modal-action">
            {{-- Form for reporting thread --}}
            <form class="ajax-form w-full" method="POST"
                action="{{ route('report', ['type' => 'thread', 'id' => $thread->id]) }}">
                @csrf

                <input type="hidden" name="creator_id" value="{{ $thread->user_id }}">
                <label for="reason" class="block text-sm font-bold mb-2">Reason:</label>
                <textarea name="reason" id="reason" class="form-textarea bg-transparent w-full rounded-lg" required></textarea>

                <div class="flex justify-end">
                     <button class="mt-2 btn"
                onclick="{{ 'reportThread' . $thread->id }}.close()">Close</button>
                <button type="submit" class="mt-2 btn btn-primary">Submit Report</button>
                </div>
                
            </form>
            {{-- end of form --}}
            
        </div>
       
    </div>
</dialog>
@endif