<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark-text leading-tight">
            {{ __('Vytvořit skupinu') }}
        </h2>
    </x-slot>
    <div class="mt-8 max-w-7xl mx-auto bg-white px-6 py-6 dark-text dark:border-2 dark:border-white dark:bg-black">
        <form action="{{ route('create-group') }}" method="post">
            @csrf
            <div class="p-2">
                <label for="title">
                    Jméno skupiny
                </label> <br>
                <input type="text" name="name" placeholder="Vložte název skupiny" class="w-full dark:text-black">
                @error('title')
                <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end items-end p-2 mt-2">
                <button type="submit" class="text-white font-bold bg-blue-500 hover:bg-blue-600 p-2 inline rounded-lg">Odeslat</button>
            </div>
        </form>
    </div>
</x-app-layout>