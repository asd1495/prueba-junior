<x-app-layout>
    <div class="p-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
            Mi Perfil
        </h2>

        <div class="space-y-4">
            <div>
                <span class="font-bold text-gray-700">Nombre:</span>
                <span class="text-gray-900">{{ $user->name }}</span>
            </div>
            <div>
                <span class="font-bold text-gray-700">Email:</span>
                <span class="text-gray-900">{{ $user->email }}</span>
            </div>
            <div>
                <span class="font-bold text-gray-700">Fecha de Registro:</span>
                <span class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
