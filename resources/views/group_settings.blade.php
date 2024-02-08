<x-app-layout class="dark:bg-black">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            Skupina {{ $group->name }}
        </h2>
    </x-slot>
    <div class="mt-2 max-w-5xl mx-auto w-full flex">
        <a href="javascript:history.back()"
        class="bg-gray-800 font-semibold text-white text-md hover:bg-gray-700 uppercase rounded-md p-2 w-full text-center">
        <i class="fa-solid fa-left-long"></i>
        Zpět
        </a>
    </div>
    <div
        class="mt-4 max-w-5xl mx-auto bg-white px-6 py-6 rounded-2xl group border-2 dark:bg-black dark:text-white h-auto">
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex dark:text-white">
            <x-nav-link :href="route('show.group', $group->id)" :active="request()->routeIs('show.group')">
                {{ __('Příspěvky') }}
            </x-nav-link>
            <x-nav-link :href="route('group_users', $group->id)" :active="request()->routeIs('group_users')">
                {{ __('Uživatelé') }}
            </x-nav-link>
            @if(Auth::user()->groups->where('id', $group->id)->first() && Auth::user()->groups->where('id', $group->id)->first()->pivot->is_moderator)
            <x-nav-link :href="route('group_settings', $group->id)" :active="request()->routeIs('group_settings')">
                {{ __('Nastavení skupiny') }}
            </x-nav-link>
            @endif
        </div>
        <span class="flex text-3xl border-b-black border-b-2 pb-2 mt-2 dark:border-b-white">
            {{ $group->name }}
        </span>
        @if ($group->users->count() != 1)
        <form method="POST" action="{{ route('transfer', $group->id) }}" class="my-2">
            @csrf
            <label for="user_id">Vyberte nového moderátora:</label>
            <select name="new_moderator">
                @foreach($group->users->where('name', '!=', 'admin') as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select> <br>
            <button class="bg-blue-600 hover:bg-blue-700 font-bold p-2 text-white rounded-lg mt-4" type="submit">Převést práva</button>
        </form>
        @endif
        <form action="{{ route('deleteGroup', $group->id) }}" method="GET">
            <button type="submit" class="bg-red-500 hover:bg-red-600 font-bold p-2 text-white rounded-lg mt-4">Odstranit skupinu</button>
        </form>
    </div>
    </div>
</x-app-layout>