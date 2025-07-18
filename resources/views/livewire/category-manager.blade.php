<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Gestión de Categorías
    </h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Controles superiores responsivos -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Buscar categorías..."
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-1/3">

        <button wire:click="create()" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">
            Crear Categoría
        </button>
    </div>

    <!-- Formulario de creación/edición -->
    @if ($showForm)
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form wire:submit.prevent="store">
                <h3 class="text-lg font-medium mb-4">{{ $categoryId ? 'Editar' : 'Crear' }} Categoría</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" wire:model.defer="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea wire:model.defer="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <label for="newImage" class="block text-sm font-medium text-gray-700">Imagen</label>
                        <input type="file" wire:model="newImage" id="newImage" class="mt-1">
                        @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @if ($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" class="mt-4 h-20 w-20 object-cover rounded">
                        @elseif ($image)
                            <img src="{{ asset('storage/' . $image) }}" class="mt-4 h-20 w-20 object-cover rounded">
                        @endif
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" wire:click="closeForm" class="text-gray-600">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Contenedor para la lista/tabla -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Vista de tabla para versión desktop -->
        <table class="min-w-full divide-y divide-gray-200 hidden md:table">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $category->id }})" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                            <button wire:click="delete({{ $category->id }})" wire:confirm="¿Estás seguro?" class="text-red-600 hover:text-red-900 ml-4">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No se encontraron categorías.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Vista para móvil -->
        <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
            @forelse ($categories as $category)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fa-solid fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $category->description ?? 'Sin descripción' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-4">
                        <button wire:click="edit({{ $category->id }})" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Editar</button>
                        <button wire:click="delete({{ $category->id }})" wire:confirm="¿Estás seguro?" class="text-sm font-medium text-red-600 hover:text-red-900">Eliminar</button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4">
                    No se encontraron categorías.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
