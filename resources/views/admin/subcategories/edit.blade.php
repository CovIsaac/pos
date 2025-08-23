<!-- archivo: resources/views/admin/subcategories/edit.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Editar Subcategoría y Productos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200 border-b border-gray-700">
                    <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Nombre de Subcategoría</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $subcategory->name) }}" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-300">Categoría</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $subcategory->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="url_img" class="block text-sm font-medium text-gray-300">URL de la Imagen</label>
                                <input type="url" name="url_img" id="url_img" value="{{ old('url_img', $subcategory->url_img) }}" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                            </div>
                        </div>
                        <hr class="my-6 border-gray-700">
                        <div>
                            <h3 class="text-lg font-medium text-gray-100">Tamaños y Precios</h3>
                            <div id="sizes-container" class="mt-4 space-y-4">
                                @if(!empty(old('sizes', $subcategory->sizes)))
                                    @foreach(old('sizes', $subcategory->sizes) as $index => $size)
                                    <div class="flex items-center space-x-4">
                                        <input type="number" name="sizes[{{ $index }}][size_oz]" placeholder="Onzas" value="{{ $size['size_oz'] ?? '' }}" required step="0.1" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                                        <input type="number" name="sizes[{{ $index }}][price]" placeholder="Precio" value="{{ $size['price'] ?? '' }}" required step="0.01" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                                        <button type="button" class="remove-size-btn px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">-</button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" id="add-size" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Añadir Tamaño</button>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Actualizar y Regenerar Productos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addSizeButton = document.getElementById('add-size');
            const sizesContainer = document.getElementById('sizes-container');
            let sizeIndex = sizesContainer.children.length;

            const addSizeRow = (size_oz = '', price = '') => {
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'items-center', 'space-x-4');
                newRow.innerHTML = `
                    <input type="number" name="sizes[${sizeIndex}][size_oz]" placeholder="Onzas (ej. 12)" value="${size_oz}" required step="0.1" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    <input type="number" name="sizes[${sizeIndex}][price]" placeholder="Precio" value="${price}" required step="0.01" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    <button type="button" class="remove-size-btn px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">-</button>
                `;
                sizesContainer.appendChild(newRow);
                sizeIndex++;
            };

            addSizeButton.addEventListener('click', () => addSizeRow());

            sizesContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-size-btn')) {
                    e.target.parentElement.remove();
                }
            });
            
            // Si no hay tamaños cargados, añadir una fila vacía para empezar
            if (sizeIndex === 0) {
                addSizeRow();
            }
        });
    </script>
    @endpush
</x-admin-layout>
