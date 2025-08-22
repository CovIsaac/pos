<x-admin-layout>
    @section('title', 'Crear Producto')

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Detalles del Producto</h2>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Nombre</span></label>
                            <input type="text" name="name" placeholder="Ej. Hamburguesa Clásica" class="input input-bordered w-full" value="{{ old('name') }}" required />
                        </div>

                        <div class="form-control w-full mt-4">
                            <label class="label"><span class="label-text">Descripción</span></label>
                            <textarea name="description" class="textarea textarea-bordered w-full" placeholder="Describe tu producto...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mt-6">
                    <div class="card-body">
                        <h2 class="card-title">Imagen</h2>
                         <input type="file" name="image" class="file-input file-input-bordered w-full" required />
                    </div>
                </div>
            </div>

            <div>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Organización</h2>

                        <div class="form-control w-full">
                             <label class="label"><span class="label-text">Categoría</span></label>
                            <select name="subcategory_id" class="select select-bordered w-full" required>
                                <option disabled selected>Elige una categoría</option>
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control w-full mt-4">
                            <label class="label"><span class="label-text">Precio</span></label>
                            <input type="number" name="price" placeholder="0.00" step="0.01" class="input input-bordered w-full" value="{{ old('price') }}" required />
                        </div>

                        <div class="form-control w-full mt-4">
                            <label class="label"><span class="label-text">Stock</span></label>
                            <input type="number" name="stock" placeholder="0" class="input input-bordered w-full" value="{{ old('stock', 0) }}" required />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>