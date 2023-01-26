<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upravit profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Aktualizace profilového obrázku') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 mb-2">
                        {{ __("Změň svůj profilový obrázek přímo tady.") }}
                    </p>
                    <form action="{{ route('update.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block font-medium text-sm text-gray-700" for="name">
                            Fotka
                        </label>
                        <input type="file" name="avatar"> <br>
                        <button type="submit" class="bg-gray-800 font-semibold text-white text-xs hover:bg-gray-700 uppercase rounded-md tracking-widest px-4 py-2 mt-4">Uložit</button>
                      </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
