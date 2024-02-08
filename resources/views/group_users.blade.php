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
            @if (Auth::user()->groups->where('id', $group->id)->first() &&
                    Auth::user()->groups->where('id', $group->id)->first()->pivot->is_moderator)
                <x-nav-link :href="route('group_settings', $group->id)" :active="request()->routeIs('group_settings')">
                    {{ __('Odstranit skupinu') }}
                </x-nav-link>
            @endif
        </div>
        <span class="flex text-3xl border-b-black border-b-2 pb-2 mt-2 dark:border-b-white">
            {{ $group->name }} - členové
        </span>
        @if ($group->users->count() != 0)
            <div class="max-w-7xl mx-auto bg-gray-200 p-2 h-auto">
                @foreach ($group->users as $user)
                    <i class="p-1 fa-solid fa-user"></i>
                    {{ $user->name }}
                    @if ($user->groups->where('id', $group->id)->first()->pivot->is_moderator)
                        - moderátor
                    @endif
                    <br>
                @endforeach
            </div>
        @else
            <div class="max-w-7xl mx-auto bg-gray-200 p-2 h-auto text-center">
                Skupina nemá žádné členy.
            </div>
        @endif
    </div>
    </div>
</x-app-layout>
