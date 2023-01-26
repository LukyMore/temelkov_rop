<x-app-layout class="dark:bg-black">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            Skupina {{ $group->name }}
        </h2>
    </x-slot>
    <div class="mt-2 max-w-5xl mx-auto">
        <a href="{{ route('groups') }}"
            class="bg-gray-800 font-semibold text-white text-xs hover:bg-gray-700 uppercase rounded-md tracking-widest p-2">
            <i class="fa-solid fa-left-long"></i>
            Zpět
        </a>
    </div>
    <div class="mt-4 max-w-5xl mx-auto bg-white px-6 py-6 rounded-2xl group border-2 dark:bg-black dark:text-white h-auto">
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex dark:text-white">
            <x-nav-link :href="route('show.group', $group->id)" :active="request()->routeIs('show.group')">
                {{ __('Příspěvky') }}
            </x-nav-link>
            <x-nav-link :href="route('group_users', $group->id)" :active="request()->routeIs('group_users')">
                {{ __('Uživatelé') }}
            </x-nav-link>
            @if(Auth::user()->groups->where('id', $group->id)->first() && Auth::user()->groups->where('id', $group->id)->first()->pivot->is_moderator)
            <x-nav-link :href="route('delete-group', $group->id)" :active="request()->routeIs('delete-group')">
                {{ __('Odstranit skupinu') }}
            </x-nav-link>
            @endif
        </div>
        <span class="flex text-3xl border-b-black border-b-2 pb-2 mt-2 dark:border-b-white">
            {{ $group->name }} - příspěvky
        </span>
        <div class="max-w-7xl mx-auto bg-gray-200 p-2 h-auto">
        @if (count($posts) != 0)
            @foreach ($posts as $post)
                <div
                    class="max-w-4xl mx-auto mb-4 bg-white px-6 py-6 rounded-2xl dark:bg-black dark:text-white dark:border-2 dark:border-white">
                    <span class="flex font-medium text-3xl pb-2 border-black border-b-2 dark:border-white">
                        <a href="{{ route('show.post', $post->id) }}" class="hover:text-blue-500">
                            {{ $post->title }}
                        </a>
                    </span>
                    <span class="w-full mt-2 flex">
                        {{ $post->body }}
                    </span>
                    <span class="justify-between items-end mt-4 flex border-t-2 border-black dark:border-white">
                        <span>Datum vytvoření: {{ $post->created_at->isoFormat('LLL') }}</span>
                        <span>
                            <i class="p-1 fa-solid fa-user"></i>
                            <a href="{{ route('user.profile', ['id' => $post->user_id]) }}">
                                {{ DB::table('users')->where('id', $post->user_id)->value('name') }}</a>
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
    </div>
@else
    <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group">
        Žádné příspěvky neexistují.
    </div>
    @endif
</div>
    </div>
</x-app-layout>
