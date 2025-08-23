<!-- archivo: resources/views/admin/subcategories/create.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Crear Subcategoría y Productos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200 border-b border-gray-700">
                    <form action="{{ route('admin.subcategories.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Nombre de Subcategoría</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-300">Categoría</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm" required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="url_img" class="block text-sm font-medium text-gray-300">URL de la Imagen</label>
                                <input type="url" name="url_img" id="url_img" class="mt-1 block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                            </div>
                        </div>
                        <hr class="my-6 border-gray-700">
                        <div>
                            <h3 class="text-lg font-medium text-gray-100">Tamaños y Precios</h3>
                            <div id="sizes-container" class="mt-4 space-y-4"></div>
                            <button type="button" id="add-size" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Añadir Tamaño</button>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.subcategories.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 mr-2">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Guardar y Crear Productos</button>
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
            // La variable sizeIndex debe empezar en 0 para la vista de creación.
            let sizeIndex = 0; 

            const addSizeRow = () => {
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'items-center', 'space-x-4');
                newRow.innerHTML = `
                    <input type="number" name="sizes[${sizeIndex}][size_oz]" placeholder="Onzas (ej. 12)" required step="0.1" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    <input type="number" name="sizes[${sizeIndex}][price]" placeholder="Precio" required step="0.01" class="block w-full bg-gray-900 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    <button type="button" class="remove-size-btn px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">-</button>
                `;
                sizesContainer.appendChild(newRow);
                sizeIndex++;
            };

            addSizeButton.addEventListener('click', addSizeRow);

            sizesContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-size-btn')) {
                    e.target.parentElement.remove();
                }
            });
            
            // Añadir la primera fila al cargar
            addSizeRow();
        });
    </script>
    @endpush
</x-admin-layout>
