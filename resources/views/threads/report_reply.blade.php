  {{-- report button --}}
  <button class="text-warning" onclick="{{ 'reportReply' . $reply->id }}.showModal()"><span
          class="material-symbols-outlined">
          report
      </span></button>

  <dialog id="{{ 'reportReply' . $reply->id }}" class="modal">
      <div class="modal-box">
          <h3 class="font-bold text-lg">report this post?</h3>


          <div class="modal-action">
              {{-- Form for reporting a post --}}
              <form class="ajax-form w-full" method="POST"
                  action="{{ route('report', ['type' => 'reply', 'id' => $reply->id]) }}">
                  @csrf


                  <input type="hidden" name="creator_id" value="{{ $reply->user_id }}">
                  <label for="reason" class="block text-sm font-bold mb-2">Reason:</label>
                  <div class="w-full">
                    <textarea name="reason" id="reason" class="w-full rounded-xl bg-transparent" required></textarea>
                  </div>
                  
                  <div class="flex justify-end">
                     <button class="btn mx-2" onclick="{{ 'reportReply' . $reply->id }}.close()">Close</button>
                  <button type="submit" class="btn btn-warning">Submit
                      Report</button>
                  </div>
                 

              </form>
              {{-- end of form --}}

          </div>
      </div>
  </dialog>
