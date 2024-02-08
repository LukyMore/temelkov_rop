<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Příspěvky
        </h2>
    </x-slot>
    <div class="max-w-7xl my-4 pt-4 mx-auto block bg-white dark:bg-black dark:text-white rounded-lg border-2">
        <div class="w-full">
            <form class="mx-2 flex" action="{{ route('search') }}" method="get">
                <input type="text" placeholder="Vyhledat..." name="query"
                    class="bg-grey-300 w-full mr-2 dark:text-black rounded-xl">
                <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 p-2 inline rounded-lg">
                    Vyhledat
                </button>
            </form>
        </div>
        <div class="w-full py-4 px-2 justify-start dark:bg-black">
            <span class="w-full text-gray-800 py-3">
                <form method="get" class="flex">
                    <span class="w-fit block text-gray-800 py-3">
                    <label for="text" class="dark:text-white">Třídit podle:</label>
                    <select name="sort_by" class="ml-1" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort_by') === 'newest' ? 'selected' : '' }}>Nejnovější
                        </option>
                        <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Nejstarší
                        </option>
                    </select>
                </span>
                <span class="w-fit block text-gray-800 py-3 ml-2">
                    <label for="text">Příspěvky ze skupiny: </label>
                    <select name="group_select" class="ml-1" onchange="this.form.submit()">
                        <option value="0">Veřejný</option>
                        @foreach ($groups as $group)
                        <option value="{{ $group->id }}" {{ Request::get('group_select') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                    </span>
                </form>
        </div>
    </div>

    @if (count($posts) != 0)
        <div class="pb-4">
            @foreach ($posts as $post)
                <div
                    class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl dark:bg-black dark:text-white border-4">
                    <span class="flex font-medium text-3xl pb-2 border-black border-b-2 dark:border-white">
                        <a href="{{ route('show.post', $post->id) }}" class="hover:text-blue-500">
                            {{ $post->title }}
                        </a>
                    </span>
                    <div class="mt-2">
                        {!! $post->body !!}
                    </div>
                    <span class="justify-between items-end mt-4 flex border-t-2 border-black dark:border-white">
                        <span>Datum vytvoření: {{ $post->created_at->isoFormat('LLL') }}</span>
                        <span>
                            <i class="p-1 fa-solid fa-user"></i>
                            <a href="{{ route('user.profile', ['id' => $post->user_id]) }}">
                                {{ DB::table('users')->where('id', $post->user_id)->value('name') }}</a>
                        </span>
                    </span>
                    @if (Auth::user()->name == 'admin' || $post->user_id == Auth::user()->id)
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
        </div>
    @else
        <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group">
            Žádné příspěvky neexistují.
        </div>
    @endif
</x-app-layout>
