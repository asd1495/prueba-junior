<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Gestión de Productos
    </h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Buscar productos..."
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-1/3">

        <button wire:click="create()" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Crear Producto
        </button>
    </div>

    @if ($showForm)
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form wire:submit.prevent="store">
                <h3 class="text-lg font-medium mb-4">{{ $productId ? 'Editar' : 'Crear' }} Producto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" wire:model.defer="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                            <input type="number" step="0.01" wire:model.defer="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" wire:model.defer="quantity" id="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select wire:model.defer="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" wire:click="closeForm" class="text-gray-600">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar</button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="applySort('products.name')" class="uppercase font-medium text-xs tracking-wider">
                            Nombre @if($sortBy === 'products.name') <i class="fa-solid fa-sort-{{ $sortDirection }}"></i> @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="applySort('categories.name')" class="uppercase font-medium text-xs tracking-wider">
                            Categoría @if($sortBy === 'categories.name') <i class="fa-solid fa-sort-{{ $sortDirection }}"></i> @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="applySort('price')" class="uppercase font-medium text-xs tracking-wider">
                            Precio @if($sortBy === 'price') <i class="fa-solid fa-sort-{{ $sortDirection }}"></i> @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="applySort('quantity')" class="uppercase font-medium text-xs tracking-wider">
                            Cantidad @if($sortBy === 'quantity') <i class="fa-solid fa-sort-{{ $sortDirection }}"></i> @endif
                        </button>
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $product->name }}</td>
                        <td class="px-6 py-4">{{ $product->category_name }}</td>
                        <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $product->quantity }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <button wire:click="edit({{ $product->id }})" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                            <button wire:click="delete({{ $product->id }})" wire:confirm="¿Estás seguro?" class="text-red-600 hover:text-red-900 ml-4">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron productos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
