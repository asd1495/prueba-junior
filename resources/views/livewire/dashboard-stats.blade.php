<div>
    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total de productos -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-indigo-100 p-3 rounded-full">
                <i class="fa-solid fa-box text-2xl text-indigo-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-500">Total de Productos</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $productCount }}</p>
            </div>
        </div>
        <!-- Total de categorías -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fa-solid fa-tags text-2xl text-green-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-500">Total de Categorías</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $categoryCount }}</p>
            </div>
        </div>
        <!-- Inventario total -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fa-solid fa-boxes-stacked text-2xl text-yellow-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-500">Inventario Total</h3>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStock }} <span class="text-lg font-normal">unidades</span></p>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productos añadidos recientemente -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Productos Recientes</h3>
            <div class="space-y-4">
                @forelse ($recentProducts as $product)
                    <div class="flex items-center justify-between space-x-4">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="flex-shrink-0">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-800 truncate">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $product->category->name ?? 'Sin categoría' }}</p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 flex-shrink-0">{{ $product->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">No hay productos recientes.</p>
                @endforelse
            </div>
        </div>

        <!-- Productos con stock bajo -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Productos con Bajo Stock (&lt; 10)</h3>
            <div class="space-y-4">
                @forelse ($lowStockProducts as $product)
                    <div class="flex items-center justify-between space-x-4">
                        <div class="flex items-center space-x-3 min-w-0">
                             <div class="flex-shrink-0">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-800 truncate">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $product->category->name ?? 'Sin categoría' }}</p>
                            </div>
                        </div>
                        <span class="font-bold text-red-500 flex-shrink-0">{{ $product->quantity }} unidades</span>
                    </div>
                @empty
                    <p class="text-gray-500">Ningún producto con bajo stock.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
