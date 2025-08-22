<x-admin-layout>
    @section('title', 'Editar Producto')

    <div class="p-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">
                        <span class="label-text">Nombre del Producto</span>
                    </label>
                    <input type="text" name="name" placeholder="Ej. Hamburguesa Clásica" class="input input-bordered w-full" value="{{ old('name', $product->name) }}" required />
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Precio</span>
                    </label>
                    <input type="number" name="price" placeholder="0.00" step="0.01" class="input input-bordered w-full" value="{{ old('price', $product->price) }}" required />
                </div>
            </div>

            <div class="mt-4">
                <label class="label">
                    <span class="label-text">Descripción</span>
                </label>
                <textarea name="description" class="textarea textarea-bordered w-full" placeholder="Describe tu producto...">{{ old('description', $product->description) }}</textarea>
            </div>


             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <label class="label">
                        <span class="label-text">Categoría</span>
                    </label>
                    <select name="subcategory_id" class="select select-bordered w-full" required>
                         <option disabled selected>Elige una categoría</option>
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                 <div>
                    <label class="label">
                        <span class="label-text">Stock</span>
                    </label>
                    <input type="number" name="stock" placeholder="0" class="input input-bordered w-full" value="{{ old('stock', $product->stock) }}" required />
                </div>
            </div>


            <div class="mt-4">
                <label class="label">
                    <span class="label-text">Imagen del Producto</span>
                </label>
                 <div class="flex items-center gap-4">
                     <div class="avatar">
                        <div class="w-24 rounded">
                            <img src="{{ asset('storage/' . $product->image) }}" />
                        </div>
                    </div>
                    <input type="file" name="image" class="file-input file-input-bordered w-full max-w-xs" />
                 </div>
                 <small class="text-gray-500">Sube una nueva imagen solo si deseas reemplazar la actual.</small>
            </div>


            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost mr-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </div>
        </form>
    </div>

</x-admin-layout>