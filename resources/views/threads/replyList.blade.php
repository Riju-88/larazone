<!-- Replies Section -->
@if ($post->replies->count() > 0)
    <div x-data="{ open: false }">
        <button x-on:click="open = !open" class="btn btn-primary btn-outline rounded-full">
            <span class="material-symbols-outlined rotate-180">
                reply
            </span>
            {{ $post->replies->count() }} {{ $post->replies->count() > 1 ? 'Replies' : 'Reply' }}</button>
        <ul x-show="open">
            @foreach ($post->replies as $index => $reply)
                <li class="bg-gray-700 px-4 py-2 my-2 rounded-xl">
                    {{-- user image --}}



                    <div class="mt-4 flex space-x-4 items-start">
                        <div>
                            <img src="{{ asset('storage/' . ($reply->user->profile_image ?? 'default/user.svg')) }}"
                                alt="User Image" class="w-12 h-12 rounded-full">
                        </div>
                        <div class="flex-1 space-y-2">
                        <div class="flex justify-between items-center">
                            <p>
                                <a class="text-xl font-semibold hover:underline"
                                    href="{{ route('view_user.show', $reply->user->id) }}">{{ $reply->user->name }}</a>
                            </p>

                            <p class=" mix-blend-difference">{{ $reply->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div
                            class="badge {{ $reply->user->badge === 'user'
                                ? 'bg-user'
                                : ($reply->user->badge === 'admin'
                                    ? 'bg-admin'
                                    : ($reply->user->badge === 'mod'
                                        ? 'bg-mod'
                                        : ($reply->user->badge === 'new user'
                                            ? 'bg-newUser'
                                            : ($reply->user->badge === 'pro'
                                                ? 'bg-pro'
                                                : ($reply->user->badge === 'negative influencer'
                                                    ? 'bg-troll'
                                                    : 'bg-primary'))))) }}">
                            {{ $reply->user->badge }}
                        </div>
                    </div>
                    </div>

                    <p class="my-4">{{ $reply->content }}</p>
                    {{-- Attached Files --}}
                    @if (!empty($reply->files))
                        <div>
                            <h2>Attached Files:</h2>
                            <ul>
                                {{-- Display images --}}
                                @foreach ($reply->files as $filePath)
                                    @php
                                        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    @endphp
                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="Attached Image"
                                            class="h-24 inline-block rounded-lg m-2">
                                    @endif
                                @endforeach

                                {{-- Display other files (non-images) --}}
                                @foreach ($reply->files as $filePath)
                                    @php
                                        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    @endphp
                                    @if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'webp', 'svg']))
                                        <div class="m-1 flex">
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                                class="text-blue-500 link hover:text-blue-700 w-auto">{{ $fileName . '.' . $extension }}</a>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @auth
                        {{-- delete reply --}}
                        @include('threads.delete_reply')
                        {{-- report reply --}}
                        @include('threads.report_reply')
                        {{--  --}}

                        {{-- Delete reply as admin --}}
                        @if (in_array(auth()->user()->role, ['admin', 'mod']))
                            <form class="ajax-form" method="POST"
                                action="{{ route('category.thread.posts.replies.destroy', ['category' => $category, 'thread' => $thread, 'post' => $post, 'reply' => $reply]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">
                                    Delete Reply as Admin
                                </button>
                            </form>
                        @endif
                    @endauth
                </li>
                {{-- if last index then div --}}
            @endforeach
        </ul>
    </div>
@endif
