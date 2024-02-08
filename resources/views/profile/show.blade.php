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
    <div class="w-full bg-blue-800 py-4 border-b-8 border-b-slate-400">
        <div class="mx-auto w-48 h-48 rounded-full">
            <img src="{{ $avatarUrl }}" class="object-cover border-pink-700 border-4 w-48 h-48 rounded-full">
        </div>
    </div>
    <div
        class="text-center rounded-b-lg border-x-8 border-b-8 border-b-slate-400 border-x-slate-400 w-96 mx-auto p-4 text-4xl">
        {{ $user->name }}
        <div class="text-center mt-4 text-lg font-normal">
            Datum vytvoření: {{ $user->created_at->isoFormat('LL') }} <br>
            Počet příspěvků: {{ count($posts) }} <br>
            Počet skupin: {{ $user->groups->count() }} <br> <br>
            @if ($user->bio_body == null && Auth::user()->id == $user->id)
            <button onclick="toggleBioForm()" class="text-blue-500 hover:underline" id="bio-add">Přidat bio</button>
            <form action="{{ route('editBio') }}" method="post" id="bio-form" class="hidden">
                @csrf
                <textarea name="bio_body" class="tinymce"></textarea>
                <button type="submit" class="bg-gray-900 px-4 py-2 font-bold text-white rounded-xl hover:bg-gray-800 mt-2">Uložit</button>
            </form>
            @elseif(Auth::user()->id == $user->id)
            <span class="w-full font-bold">BIO</span>
            <hr>
            <button onclick="toggleBioForm()" class="text-blue-500 hover:underline" id="bio-add">Upravit</button> |
            <form action="{{ route('deleteBio') }}" method="post" class="inline">
                @csrf
                <button type="submit" class="text-blue-500 hover:underline">Smazat</button>
            </form>
            <form action="{{ route('editBio') }}" method="post" id="bio-form" class="hidden">
                @csrf
                <textarea name="bio_body" class="tinymce">{{ $user->bio_body }}</textarea>
                <button type="submit" class="bg-gray-900 px-4 py-2 font-bold text-white rounded-xl hover:bg-gray-800 mt-2">Uložit</button>
            </form>
            <p>{!! $user->bio_body !!}</p>
            @else
            <span class="w-full font-bold">BIO</span>
            <hr>
            <p>{!! $user->bio_body !!}</p>
            @endif
        </div>
    </div>
    @if (count($posts) != 0)
        <div class="max-w-7xl p-3 mt-2 mx-auto bg-gray-200 overflow-y-scroll max-h-96 border-4 border-slate-400">
            <h2 class="font-serif text-3xl">Všechny příspěvky</h2>
            @foreach ($posts as $post)
                <div class="mt-4 max-w-7xl mx-auto bg-white px-6 py-6 rounded-2xl group">
                    <span class="flex font-medium text-4xl pb-2 border-black border-b-2">
                        <a href="{{ route('show.post', $post->id) }}" class="hover:text-blue-500">
                            {{ $post->title }}
                        </a>
                    </span>
                    <span class="w-full mt-2 flex">
                        {!! $post->body !!}
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
    <script>
        function toggleBioForm() {
            const form = document.getElementById(`bio-form`);
            form.classList.toggle('hidden');
            form.scrollIntoView();
        }
    </script>
</x-app-layout>
