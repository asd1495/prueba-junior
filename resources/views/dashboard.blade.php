<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                <!-- Saludo inicial -->
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        ¡Bienvenido de nuevo, {{ Auth::user()->name }}!
                    </h2>
                    <p class="mt-1 text-gray-600">Aquí tienes un resumen de tu inventario:</p>
                </div>

                <!-- Componente de Livewire para las estadísticas y el gráfico -->
                <livewire:dashboard-stats />

            </div>
        </div>
    </div>
</x-app-layout>
