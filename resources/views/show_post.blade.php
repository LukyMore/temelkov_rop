<x-app-layout class="dark:bg-black">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Vyhledávání') }}
        </h2>
        <script src="https://cdn.tiny.cloud/1/unftqo57k6yahkdadtqq2mam2s8n2ty7ka7yq9buhzuifb8w/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                menubar: false,
                selector: 'textarea.tinymce',
                resize: false,
                branding: false,
                statusbar: false,
                height: 300,
                plugins: 'emoticons autoresize',
                toolbar: 'bold italic underline strikethrough | emoticons',
            });
        </script>
    </x-slot>
    <div class="mt-2 max-w-5xl w-full mx-auto flex">
        <a href="{{ route('posts') }}"
            class="bg-gray-800 font-semibold text-white text-md hover:bg-gray-700 uppercase rounded-md p-2 w-full text-center">
            <i class="fa-solid fa-left-long"></i>
            Zpět
        </a>
    </div>
    <div class="mt-4 max-w-5xl mx-auto bg-white px-6 py-6 rounded-2xl group border-2 dark:bg-black dark:text-white">
        <span class="flex text-3xl font-medium w-full border-b-black border-b-2 pb-2 mt-2 dark:border-b-white">
            {{ $post->title }}
        </span>
        <div class="mt-2 py-2">
            {!! $post->body !!}
        </div>
        <span class="justify-between items-end mt-2 flex border-black border-t-2 dark:border-white">
            <span>Datum vytvoření: {{ $post->created_at->isoFormat('LLL') }}</span>
            <span>
                @if (DB::table('users')->where('id', $post->user_id)->value('name') == 'admin')
                    <i class="p-1 fa-solid fa-user"></i>
                @else
                    <i class="p-1 fa-regular fa-user"></i>
                @endif
                <a href="{{ route('user.profile', ['id' => $post->user_id]) }}">
                    {{ DB::table('users')->where('id', $post->user_id)->value('name') }}</a>
            </span>
        </span>
    </div>
    <div
        class="bg-white rounded-2xl text-black mt-2 max-w-5xl mx-auto p-2 border-2 ">
        <form action="{{ route('create-comment', $post->id) }}" method="post">
            @csrf
            <div class="p-2">
                <h2 class="border-b-2 border-b-black font-bold dark:border-b-white">Přidat komentář: </h2> <br>
                <label for="text">Obsah</label>
                <textarea name="body" class="w-full h-20 overflow-hidden resize-none dark:bg-black dark:border-2 tinymce"></textarea>
                <button type="submit"
                    class="text-white border-2 p-2 mt-1 rounded-lg bg-blue-500 font-bold hover:bg-blue-600">Přidat</button>
            </div>
        </form>
    </div>
    <h2 class="font-bold border-b-black border-b-2 max-w-5xl mx-auto my-2">
        Všechny komentáře ({{ count($comments) }})
    </h2>
    @if (count($comments) == 0)
        <h2 class="font-bold text-black text-center">Příspěvek nemá žádné komentáře</h2>
    @else
        <div class="pb-3">
            @foreach ($comments as $comment)
                <div
                    class="bg-white dark:bg-black rounded-xl p-2 text-black border-2 mt-2 max-w-5xl mx-auto dark:border-white">
                    <span class="w-full font-bold text-sm p-2 flex dark:text-white justify-between">
                        <span class="w-fit inline-flex">
                            <img src="{{ Storage::url(\App\Models\user::find($comment->user_id)->avatar) }}"
                                class="rounded-full w-6 h-6 mr-2">
                            <a href="{{ route('user.profile', $comment->user_id) }}" class="pt-0.5">
                                <?php
                                ?>
                                {{ \App\Models\user::find($comment->user_id)->name }}
                            </a>
                        </span>
                        <h1 class="inline-flex pt-0.5">
                            {{ $comment->created_at->isoFormat('LLL') }}
                            @if ($comment->created_at != $comment->updated_at)
                                (upraveno)
                            @endif
                            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown{{ $comment->id }}"
                                class="text-black hover:text-blue-500 rounded-lg px-4 pt-0.5 text-center items-center"
                                type="button"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <div id="dropdown{{ $comment->id }}"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <button onclick="edit({{ $comment->id }})"
                                            data-dropdown-toggle="dropdown{{ $comment->id }}"
                                            class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-blue-500"><i
                                                class="fa-solid fa-pen-to-square pr-2"></i>Upravit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('delete-comment', $comment->id) }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-red-500"><i
                                                    class="fa-solid fa-trash pr-2"></i>Smazat</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <button onclick="toggleReplyForm({{ $comment->id }})"
                                class="text-black hover:text-blue-500 rounded-lg pt-0.5 text-center items-center"
                                type="button"><i class="fa-solid fa-reply"></i>
                            </button>
                        </h1>
                    </span>
                    <div class="p-2 dark:text-white">
                        <form action="{{ route('update-comment', $comment->id) }}" method="post" class="hidden"
                            id="editText{{ $comment->id }}">
                            @csrf
                            <textarea name="updatedText" class="tinymce w-full mb-10">{!! $comment->body !!}</textarea>
                            <button type="submit"
                                class="bg-blue-600 w-fit rounded-lg p-2 font-bold text-white">Uložit</button>
                            <button class="bg-blue-600 w-fit rounded-lg p-2 text-white font-bold"
                                onclick="edit({{ $comment->id }}); event.preventDefault();">Zrušit</button>
                        </form>
                        <div id="text{{ $comment->id }}">
                            {!! $comment->body !!}
                        </div>
                    </div>
                    @if ($comment->replies->count() > 0)
                        @foreach ($comment->replies as $reply)
                            <div
                                class="bg-white dark:bg-black rounded-xl p-2 text-black border-4 mt-2 max-w-5xl mx-auto dark:border-white">
                                <span class="w-full font-bold text-sm p-2 flex dark:text-white justify-between">
                                    <span class="w-fit inline-flex">
                                        <img src="{{ Storage::url(\App\Models\user::find($reply->user_id)->avatar) }}"
                                            class="rounded-full w-6 h-6 mr-2">
                                        <a href="{{ route('user.profile', $reply->user_id) }}" class="pt-0.5">
                                            {{ \App\Models\user::find($reply->user_id)->name }}
                                        </a>
                                    </span>
                                    <h1 class="inline-flex pt-0.5">
                                        {{ $reply->created_at->isoFormat('LLL') }}
                                        <button id="dropdownDefaultButton"
                                            data-dropdown-toggle="dropdown{{ $reply->id }}"
                                            class="text-black hover:text-blue-500 rounded-lg px-4 pt-0.5 text-center items-center"
                                            type="button"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                        <div id="dropdown{{ $reply->id }}"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownDefaultButton">
                                                <li>
                                                    <a href="#"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-blue-500"><i
                                                            class="fa-solid fa-pen-to-square pr-2"></i>Upravit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('delete-comment', $reply->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-red-500"><i
                                                                class="fa-solid fa-trash pr-2"></i>Smazat</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </h1>
                                </span>
                                <div class="p-2 dark:text-white">
                                    {!! $reply->body !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="hidden mt-4" id="reply-form-{{ $comment->id }}">
                        <form action="{{ route('create-reply', $post->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <label for="reply-body" class="block text-gray-700 font-bold mb-2">Reply</label>
                            <div class="my-2">
                                <textarea name="body" class="tinymce w-full"></textarea>
                            </div>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            form.classList.toggle('hidden');
            form.scrollIntoView();
        }

        function edit(commentId) {
            const form = document.getElementById(`editText${commentId}`);
            const text = document.getElementById(`text${commentId}`);
            form.classList.toggle('hidden');
            text.classList.toggle('hidden');
            form.scrollIntoView(true);
        }
    </script>
</x-app-layout>
