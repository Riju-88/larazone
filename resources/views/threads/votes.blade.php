   {{-- up and down votes --}}
   <!-- Upvote and Downvote buttons for comments -->
   <div class="flex gap-2">
    <div>
       <form class="ajax-form" method="POST" action="{{ route('posts.upvote', ['post' => $post]) }}">
           @csrf
           @if ($post->userUpvoted())
               <button type="submit" class=" rounded-l-full border border-primary btn-outline flex align-center py-2 px-4" title="Upvote"><span class="material-symbols-outlined material-symbols-filled text-success">shift</span>
               </button>
           @else
               <button type="submit" class=" rounded-l-full border border-primary btn-outline flex align-center py-2 px-4" title="Upvote"><span class="material-symbols-outlined">shift</span>
               </button>
           @endif
       </form>
       <p class="text-gray-400 text-center">{{ $post->upvotes }}</p>
</div>
<div>
       <form class="ajax-form" method="POST" action="{{ route('posts.downvote', ['post' => $post]) }}">
           @csrf
           @if ($post->userDownvoted())
               <button type="submit" class=" rounded-r-full border border-primary btn-outline flex align-center py-2 px-4" title="Downvote"><span class="material-symbols-outlined material-symbols-filled rotate-180 text-error">
                       shift
                   </span></button>
           @else
               <button type="submit" class=" rounded-r-full border border-primary btn-outline flex align-center py-2 px-4" title="Downvote"><span class="material-symbols-outlined rotate-180">
                       shift
                   </span></button>
           @endif

       </form> 
       <p class="text-gray-400 text-center">{{ $post->downvotes }}</p>
</div>
      
   </div>
