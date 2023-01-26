<x-app-layout class="dark:bg-black">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Vyhledávání') }}
        </h2>
    </x-slot>
    <div class="mt-2 max-w-5xl mx-auto">
        <a href="javascript:history.back()"
            class="bg-gray-800 font-semibold text-white text-xs hover:bg-gray-700 uppercase rounded-md tracking-widest p-2">
            <i class="fa-solid fa-left-long"></i>
            Zpět
        </a>
    </div>
    <div class="mt-4 max-w-5xl mx-auto bg-white px-6 py-6 rounded-2xl group border-2 dark:bg-black dark:text-white">
        <span class="flex text-3xl w-full border-b-black border-b-2 pb-2 mt-2 dark:border-b-white">
            {{ $post->title }}
        </span>
        <span class="w-full mt-2 flex">
            {{ $post->body }}
        </span>
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
        class="bg-white rounded-md text-black mt-2 max-w-5xl mx-auto p-2 dark:bg-black dark:text-white dark:border-white dark:border-2">
        <form action="{{ route('create-comment') }}" method="post">
            @csrf
            <div class="p-2">
                <h2 class="border-b-2 border-b-black font-bold dark:border-b-white">Přidat komentář: </h2> <br>
                <label for="text">Obsah</label>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="body" class="w-full h-20 overflow-hidden resize-none dark:bg-black dark:border-2 dark:border-white"></textarea>
                <button type="submit" class="btn-dark">Přidat</button>
            </div>
        </form>
    </div>
    <h2 class="font-bold border-b-black border-b-2 max-w-5xl mx-auto my-2">
        Všechny komentáře - počet {{ count($comments) }}
    </h2>
    @if (count($comments) == 0)
        <h2 class="font-bold text-black text-center">Příspěvek nemá žádné komentáře</h2>
    @else
        <div class="pb-3">
            @foreach ($comments as $comment)
                <div
                    class="bg-white dark:bg-black rounded-xl p-2 text-black border-2 border-black mt-2 max-w-5xl mx-auto dark:border-white">
                    <span class="w-full font-bold text-sm p-2 flex dark:text-white justify-between">
                        <span class="w-fit inline-flex">
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" class="rounded-full w-6 h-6 mr-2">
                            <a href="{{ route('user.profile', $comment->user_id) }}" class="pt-0.5">
                                {{ Auth::user()->name }}
                            </a>
                        </span>
                        <h1 class="inline-flex pt-0.5">
                            {{ $comment->created_at->isoFormat('LL') }}
                        </h1>
                    </span>
                    <div class="p-2 dark:text-white">
                        {{ $comment->body }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>
</x-app-layout>
