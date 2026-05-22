<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meu Perfil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">

                <div>
                    <span class="text-sm font-medium text-gray-500">Nome</span>
                    <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                </div>

                <div>
                    <span class="text-sm font-medium text-gray-500">E-mail</span>
                    <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                </div>

                <div>
                    <span class="text-sm font-medium text-gray-500">Perfil</span>
                    <p class="mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            User
                        </span>
                    </p>
                </div>

                <div>
                    <span class="text-sm font-medium text-gray-500">Membro desde</span>
                    <p class="mt-1 text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('profile.edit') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
