  {{-- report button --}}
  <button class="text-warning flex items-center" onclick="{{ 'report' . $post->id }}.showModal()"><span class="material-symbols-outlined" title="report">
    report
    </span></button>

  <dialog id="{{ 'report' . $post->id }}" class="modal">
      <div class="modal-box">
          <h3 class="font-bold text-lg">report this post?</h3>


          <div class="modal-action">
              {{-- Form for reporting a post --}}
              <form class="ajax-form w-full" method="POST"
                  action="{{ route('report', ['type' => 'post', 'id' => $post->id]) }}">
                  @csrf


                  <input type="hidden" name="creator_id" value="{{ $post->user_id }}">
                  <label for="reason" class="block text-sm font-bold mb-2">Reason:</label>
                  <textarea name="reason" id="reason" class="form-textarea w-full bg-transparent rounded-xl" required></textarea>

                  <div class="flex justify-end">
                     <button class="btn mx-2" onclick="{{ 'report' . $post->id }}.close()">Close</button>
                     <button type="submit" class="btn btn-warning">Submit Report</button>

                  </div>
                
              </form>
              {{-- end of form --}}
              
          </div>
      </div>
  </dialog>
  {{--  --}}