<!-- Comment Section -->
<div class="mt-4">


    <!-- Form to Post a Comment -->
    <form class="ajax-form" method="POST"
        action="{{ route('category.thread.posts.store', ['category' => $category, 'thread' => $thread]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-3 max-w-3xl mx-auto p-6 rounded-2xl shadow-md bg-neutral">
            <label for="comment">Comment:</label>
            <input id="x" type="hidden" name="content">
            <trix-editor input="x" class=""></trix-editor>

            <!-- File Upload -->
            <div class="mb-4">
                <label for="files" class="block text-gray-700 text-sm font-bold mb-2">Upload Files:</label>

                <input type="file" name="files[]" id="files"
                    class="file-input file-input-bordered file-input-primary w-full max-w-xs bg-transparent" multiple>
            </div>
            <button type="submit" class="btn btn-primary btn-outline rounded-full hover:scale-105 m-2">
                Comment
                <span class="material-symbols-outlined">
                    send
                    </span>
            </button>
        </div>

    </form>
</div>
