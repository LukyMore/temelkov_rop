<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Smazat účet') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Permanentně smaže účet. Smaže všechny příspěvky a komentáře, který daný uživatel vytvořil.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Smazat účet') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user-delete', Auth::user()->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">Opravdu chcete smazat tento účet?</h2>
 
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Permanentně smaže účet. Smaže všechny příspěvky a komentáře, který daný uživatel vytvořil.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Zavřít') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Smazat účet') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
