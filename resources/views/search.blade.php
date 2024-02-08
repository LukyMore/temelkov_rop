<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark-text leading-tight">
            {{ __('Vyhledávání') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl my-4 mx-auto block bg-white p-2 dark-text dark:bg-black dark:border-2 dark:border-white">
        <form class="w-full flex" action="{{ route('search') }}" method="get">
            <input type="text" placeholder="Vyhledat..." name="query" class="bg-grey-300 w-full mr-2 rounded-xl">
            <button type="submit" class="btn-dark">
                Vyhledat
            </button>
        </form>
        <form action="{{ route('posts') }}" method="get">
            <button type="submit"
                class="block py-1 px-2 mt-2 border w-fit dark-text hover:bg-red-600 hover:text-white hover:transition hover:cursor-pointer group">
                <div class="hidden group-hover:inline">
                    <i class="ml-1 fa-regular fa-trash-can"></i>
                </div>
                Výsledek vyhledávání: {{ $query }}
            </button>
        </form>
    </div>
    @if (!$posts->isEmpty())
        @foreach ($posts as $post)
            <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group dark-text dark:border-2 dark:border-white dark:bg-black">
                <span class="flex font-medium text-3xl pb-2 border-black border-b-2 dark:border-white">
                    <a href="{{ route('show.post', $post->id) }}" class="hover:text-blue-500">
                        {!! $post->title !!}
                    </a>
                </span>
                <span class="w-full mt-2 flex">
                    {!! $post->body !!}
                </span>
                <span class="justify-between items-end mt-2 flex border-t-2 border-black dark:border-white">
                    <span>Datum vytvoření: {{ $post->created_at->isoFormat('LLL') }}</span>
                    <span>
                    @if (DB::table('users')->where('id', $post->user_id)->value('name') == 'admin')
                        <i class="p-1 fa-solid fa-user"></i>
                    @else
                        <i class="p-1 fa-regular fa-user"></i>
                    @endif
                    {{ DB::table('users')->where('id', $post->user_id)->value('name') }}
                </span>
                </span>
                @if (Auth::user()->name == 'admin')
                <span class="block pt-2">
                <a href="{{ route('edit.post', $post->id) }}">
                    <button class="bg-blue-500 text-white p-2" title="Upravit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </a>
                    <form action="{{ route('delete-post', $post->id) }}" method="post" class="inline">
                        @csrf
                        <button class="bg-red-500 text-white p-2" title="Vymazat">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </span>
            @endif
            </div>
        @endforeach
    @else
        <div class="w-full mx-auto max-w-7xl bg-white text-black p-2">
            Nebyly nalezeny žádné příspěvky.
        </div>
    @endif
</x-app-layout>
