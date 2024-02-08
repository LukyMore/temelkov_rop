<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark-text leading-tight">
            {{ __('Vytvořit příspěvek') }}
        </h2>
        <script>
            tinymce.init({
                menubar: false,
                selector: 'textarea.tinymce',
                resize: false,
                branding: false,
                statusbar: false,
                height: 300,
                plugins: 'emoticons autoresize',
                toolbar: 'bold italic underline strikethrough | emoticons',
            });
        </script>
    </x-slot>
    <div class="mt-8 max-w-7xl mx-auto bg-white px-6 py-6 dark-text dark:border-2 dark:border-white dark:bg-black">
        <form action="{{ route('create-post') }}" method="post">
            @csrf
            <div class="p-2">
                <label for="title">
                    Název
                </label> <br>
                <input type="text" name="title" placeholder="Vložte název článku" class="w-full dark:text-black">
                @error('title')
                    <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="p-2">
                <label for="title">
                    Obsah
                </label> <br>
                <textarea name="body" class="w-full h-56 dark:text-black tinymce" id="tinymce" placeholder="Vložte obsah článku"></textarea>
                @error('body')
                    <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="p-2">
                <select name="group_id" id="group_id" class="form-control text-center">
                    <option value="choose">Vyberte možnost:</option>
                    <option value="0">Veřejný</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select> <br>
                @error('group_id')
                    <span class="font-bold text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end items-end p-2 mt-2">
                <button type="submit" class="text-white font-bold bg-blue-500 hover:bg-blue-600 p-2 inline rounded-lg">Odeslat</button>
            </div>
        </form>
    </div>
</x-app-layout>
