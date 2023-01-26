<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark-text leading-tight">
            {{ __('Upravit příspěvek') }}
        </h2>
    </x-slot>
    <div class="mt-8 max-w-7xl mx-auto bg-white px-6 py-6 dark:bg-black dark:border-2 dark:border-white dark-text">
        <form action="{{ route('edit-post', $post->id) }}" method="post">
            @csrf
            <div class="p-2">
                <label for="title">
                    Název
                </label> <br>
                <input type="text" name="title" placeholder="Vložte název článku" class="w-full dark:text-black" value="{{ $post->title }}">
                @error('title')
                <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="p-2">
                <label for="title">
                    Obsah
                </label> <br>
                <textarea name="body" class="w-full h-56 dark:text-black" placeholder="Vložte obsah článku">{{ $post->body }}</textarea>
                @error('body')
                <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end items-end p-2 mt-2">
                <button type="submit" class="btn-dark">Odeslat</button>
            </div>
        </form>
    </div>
</x-app-layout>
