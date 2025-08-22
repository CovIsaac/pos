<x-admin-layout>
    @section('title', 'Productos')

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Crear Producto
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="table w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <th>{{ $product->id }}</th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                        {{ $product->subcategory->category->name }}
                        <br/>
                        <span class="badge badge-ghost badge-sm">{{ $product->subcategory->name }}</span>
                        </td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->stock > 10)
                                <span class="badge badge-success">{{ $product->stock }} en Stock</span>
                            @elseif($product->stock > 0)
                                <span class="badge badge-warning">{{ $product->stock }} bajo stock</span>
                            @else
                                <span class="badge badge-error">Agotado</span>
                            @endif
                        </td>
                        <td class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost btn-xs" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"></path></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-xs text-red-500" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="flex flex-col items-center">
                                <p>No se encontraron productos.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary mt-2">Crear el primero</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

</x-admin-layout>