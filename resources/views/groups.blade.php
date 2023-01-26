<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Skupiny
        </h2>
    </x-slot>
    <div class="max-w-7xl my-4 pt-4 mx-auto block bg-white dark:bg-black dark:text-white">
        <div class="w-full">
            <form class="mx-2 flex" action="{{ route('search') }}" method="get">
                <input type="text" placeholder="Vyhledat..." name="query"
                    class="bg-grey-300 w-full mr-2 dark:text-black rounded-xl">
                <button type="submit" class="btn-dark inline rounded-none">
                    Vyhledat
                </button>
            </form>
        </div>
        <div class="block py-4 px-2 justify-start dark:bg-black">
            <span class="w-fit text-gray-800 py-3">
                <form method="get">
                    <label for="text" class="dark:text-white">Třídit podle:</label>
                    <select name="sort_by" class="ml-1" onchange="this.form.submit()">
                        <option value="recent" {{ request('sort_by') === 'newest' ? 'selected' : '' }}>Nejnovější
                        </option>
                        <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Nejstarší
                        </option>
                    </select>
                </form>
            </span>
        </div>
    </div>

    @if (count($groups) != 0)
        <div class="pb-4">
            @foreach ($groups as $group)
                <div
                    class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl dark:bg-black dark:text-white dark:border-2 dark:border-white justify-between flex">
                    <span class="flex font-medium text-3xl pb-2 dark:border-white">
                        <a href="{{ route('show.group', $group->id) }}" class="hover:text-blue-500">
                            {{ $group->name }}
                        </a>
                    </span>
                    <div class="flex justify-between">
                        @if (!Auth::user()->groups->contains($group))
                        <h2 class="font-bold p-2">Nejste členem.</h2>
                            <form action="{{ route('addUserToGroup', $group->id) }}" method="GET">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 font-bold p-2 text-white rounded-lg">Přidat se do skupiny</button>
                            </form>
                        @else
                            <h2 class="font-bold p-2">Již jste členem.</h2>
                            <form action="{{ route('deleteUserFromGroup', $group->id) }}" method="GET">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 font-bold p-2 text-white rounded-lg">Odejít ze skupiny</button>
                            </form>
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
