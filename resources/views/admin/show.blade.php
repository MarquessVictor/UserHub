<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil de {{ $user->name }}
            </h2>
            <a href="{{ route('admin.index') }}" class="text-indigo-600 hover:underline text-sm">
                ← Voltar ao painel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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
                    <span class="text-sm font-medium text-gray-500">Criado em</span>
                    <p class="mt-1 text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="flex space-x-3 pt-4">
                    <a href="{{ route('admin.edit', $user) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Editar
                    </a>
                    <form action="{{ route('admin.promote', $user) }}" method="POST"
                          onsubmit="return confirm('Promover {{ $user->name }} a administrador?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Promover a Admin
                        </button>
                    </form>
                    <form action="{{ route('admin.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Confirmar exclusão?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
