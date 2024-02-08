<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark-text leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>
    <div class="rounded-lg mx-auto bg-white max-w-7xl mt-5 p-2">
        
        <div class="text-xl font-bold text-center w-full py-2">
            Admin Panel
        </div>
        <hr>
        @if ($users->count() != 0)
        <table class="table-fixed w-full border-collapse">
            <thead>
            <tr>
                <th class="border-2 p-2">Jméno</th>
                <th class="border-2 p-2">E-mail</th>
                <th class="border-2 p-2">Datum vytvoření</th>
                <th class="border-2 p-2">Akce</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($users as $user)
            <tr>
                <td class="border-2 p-2">{{ $user->name }}</td>
                <td class="border-2 p-2">{{ $user->email }}</td>
                <td class="border-2 p-2">{{ $user->created_at->isoFormat('LL') }}</td>
                <td class="border-2 p-2">
                    <form action="{{ route('user-delete', $user->id) }}" method="post">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 py-2 px-6 rounded-lg font-bold text-white text-md">Smazat</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @else
        <div class="text-center w-full text-lg my-2">
            Fórum nemá zatím žádné uživatele.
        </div>
        @endif
    </div>
</x-app-layout>