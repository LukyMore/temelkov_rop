<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Skupiny
        </h2>
    </x-slot>
    <div class="max-w-7xl my-4 p-4 mx-auto block bg-white dark:bg-black dark:text-white">
        <div class="w-full">
            <form class="mx-2 flex" action="{{ route('searchGroups') }}" method="post">
                @csrf
                <input type="text" placeholder="Vyhledat..." name="query"
                    class="bg-grey-300 w-full mr-2 dark:text-black rounded-xl">
                <button type="submit" class="text-white font-bold bg-blue-500 hover:bg-blue-600 p-2 inline rounded-lg">
                    Vyhledat
                </button>
            </form>
            @if (isset($query))
                <button
                    class="block py-1 px-2 mt-2 border w-fit dark-text hover:bg-red-600 hover:text-white hover:transition hover:cursor-pointer group">
                    <div class="hidden group-hover:inline">
                        <i class="ml-1 fa-regular fa-trash-can"></i>
                    </div>
                    <a href="{{ route('groups') }}">
                    Výsledek vyhledávání: {{ $query }}
                    </a>
                </button>
            @endif
        </div>
    </div>

    @if (count($groups) != 0)
        <div class="pb-4">
            @foreach ($groups as $group)
                <div
                    class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl dark:bg-black dark:text-white dark:border-2 dark:border-white justify-between flex">
                    <span class="flex font-medium text-3xl pb-2 dark:border-white">
                        @if (Auth::user()->groups->where('id', $group->id)->first())
                        <a href="{{ route('show.group', $group->id) }}" class="hover:text-blue-500">
                            {{ $group->name }}
                        </a>
                        @else
                        <h1>
                            {{ $group->name }}
                        </h1>
                        @endif
                    </span>
                    <div class="flex justify-between">
                        @if (!Auth::user()->groups->contains($group))
                            <h2 class="font-bold p-2">Nejste členem.</h2>
                            <form action="{{ route('addUserToGroup', $group->id) }}" method="GET">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 font-bold p-2 text-white rounded-lg">Připojit
                                    se do skupiny</button>
                            </form>
                        @else
                            <h2 class="font-bold p-2">Již jste členem.</h2>
                            <form action="{{ route('deleteUserFromGroup', $group->id) }}" method="GET">
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 font-bold p-2 text-white rounded-lg">Odejít ze
                                    skupiny</button>
                            </form>
                            @if (Auth::user()->groups->where('id', $group->id)->first() && Auth::user()->groups->where('id', $group->id)->first()->pivot->is_moderator)
                            <button class="bg-blue-600 hover:bg-blue-700 font-bold p-2 text-white rounded-lg mx-2">
                                <a href="{{ route('group_settings', $group->id) }}">Nastavení</a>
                            </button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group">
            Žádné příspěvky neexistují.
        </div>
    @endif
</x-app-layout>
