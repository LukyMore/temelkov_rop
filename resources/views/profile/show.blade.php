<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  dark-text leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>
    @if (empty($user->avatar))
        <?php $avatarUrl = asset('storage/1.jpg'); ?>
    @else
        <?php $avatarUrl = Storage::url($user->avatar); ?>
    @endif
    <div class="w-full bg-gray-700 py-4 border-b-8 border-b-slate-400">
        <div class="mx-auto w-48 h-48 rounded-full">
            <img src="{{ $avatarUrl }}" class="object-cover border-pink-700 border-4 w-48 h-48 rounded-full">
        </div>
    </div>
    <div
        class="text-center rounded-b-lg border-x-8 border-b-8 border-b-slate-400 border-x-slate-400 w-96 mx-auto p-4 text-4xl  dark-text">
        {{ $user->name }}
        <div class="text-center mt-4 text-lg font-normal">
            Datum vytvoření: {{ $user->created_at->isoFormat('LL') }} <br>
            Počet příspěvků: {{ count($posts) }}
        </div>
    </div>
    @if (count($posts) != 0)
        <div class="max-w-7xl p-3 mt-2 mx-auto bg-gray-200 overflow-y-scroll max-h-96 border-4 border-slate-600">
            <h2 class="font-serif text-3xl">Všechny příspěvky</h2>
            @foreach ($posts as $post)
                <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group">
                    <span class="flex font-medium text-4xl pb-2 border-black border-b-2">
                        {{ $post->title }}
                    </span>
                    <span class="w-full mt-2 flex">
                        {{ $post->body }}
                    </span>
                    <span class="mt-2 flex border-t-2 border-black">Datum vytvoření:
                        {{ $post->created_at->isoFormat('LLL') }}</span>
                    <span class="block pt-2">
                        <a href="{{ route('edit.post', $post->id) }}">
                            <button class="bg-blue-500 text-white p-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </a>
                        <form action="{{ route('delete-post', $post->id) }}" method="post" class="inline">
                            @csrf
                            <button class="bg-red-500 text-white p-2">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </span>
                </div>
            @endforeach
        </div>
    @else
        <div class="max-w-7xl p-3 mt-2 mx-auto bg-white max-h-96 border-4">
            <h2 class="font-serif text-3xl text-center">Uživatel nezveřejnil žádné příspěvky</h2>
        </div>
    @endif
</x-app-layout>
