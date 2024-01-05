  <!-- Form to Post a Reply -->
  {{-- better to add a dialog to write inside --}}
  <form class="ajax-form" method="POST"
  action="{{ route('category.thread.posts.replies.store', ['category' => $category, 'thread' => $thread, 'post' => $post]) }}"
  enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
      <label for="reply" class="text-sm font-bold mb-2 block">Reply:</label>
      <textarea name="content" id="reply" class="p-6 rounded-xl border border-primary bg-transparent w-full mx-auto" required></textarea>
  </div>
  <!-- File Upload -->
  <div class="mb-4 max-w-sm">
      <label for="filesR" class="block text-gray-700 text-sm font-bold mb-2">Upload
          Files:</label>
      <input type="file" name="filesR[]" id="filesR" class="file-input file-input-bordered file-input-primary w-full max-w-xs bg-transparent" multiple>
  </div>
  <div>
      <button type="submit" class="btn btn-primary rounded-full btn-outline">Post Reply</button>
  </div>
</form>