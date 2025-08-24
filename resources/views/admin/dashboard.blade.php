<!-- archivo: resources/views/admin/dashboard.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard de Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="bg-base-100 p-4 rounded-lg shadow-md mb-6">
                <form id="filter-form" action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="label">Desde:</label>
                            <input type="date" name="date_from" id="date_from" class="input input-bordered w-full" value="{{ request('date_from') }}">
                        </div>
                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="label">Hasta:</label>
                            <input type="date" name="date_to" id="date_to" class="input input-bordered w-full" value="{{ request('date_to') }}">
                        </div>
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="label">Categoría:</label>
                            <select name="category_id" id="category_id" class="select select-bordered w-full">
                                <option value="">Todas</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Subcategory -->
                        <div>
                            <label for="subcategory_id" class="label">Subcategoría:</label>
                            <select name="subcategory_id" id="subcategory_id" class="select select-bordered w-full">
                                <option value="">Todas</option>
                                 @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2 justify-end">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Limpiar</a>
                        <button type="submit" form="export-pdf-form" class="btn btn-secondary"><i class="fas fa-file-pdf mr-2"></i>PDF</button>
                        <button type="submit" form="export-excel-form" class="btn btn-success"><i class="fas fa-file-excel mr-2"></i>Excel</button>
                    </div>
                </form>
                <!-- Hidden forms for export -->
                <form id="export-pdf-form" action="{{ route('admin.dashboard.export.pdf') }}" method="GET" class="hidden">@csrf</form>
                <form id="export-excel-form" action="{{ route('admin.dashboard.export.excel') }}" method="GET" class="hidden">@csrf</form>
            </div>

            <!-- Sales Cards Grid -->
            <div id="orders-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                 @forelse($orders as $order)
                    <div class="card bg-base-100 shadow-xl order-card" data-date="{{ $order->created_at->toDateString() }}">
                        <div class="card-body">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="card-title">Venta #{{ $order->id }}</h2>
                                    <p class="text-sm text-gray-400">{{ $order->customer_name }}</p>
                                </div>
                                <div class="badge {{ $order->payment_method == 'cash' ? 'badge-success' : 'badge-info' }}">{{ ucfirst($order->payment_method) }}</div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d/m/Y h:i A') }}</p>
                            <div class="divider my-2"></div>
                            <ul class="space-y-1 text-sm">
                                @foreach($order->details as $detail)
                                    @if ($detail->product)
                                    <li class="flex justify-between">
                                        <span>{{ $detail->quantity }}x {{ $detail->product->name }} ({{ $detail->product->size_oz }} oz)</span>
                                        <span>${{ number_format($detail->price * $detail->quantity, 2) }}</span>
                                    </li>
                                    @else
                                    <li class="text-error">Producto no encontrado</li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="divider my-2"></div>
                            <div class="card-actions justify-end">
                                <div class="text-lg font-bold">Total: ${{ number_format($order->total_price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-base-100 rounded-lg">
                        <p class="text-gray-500">No se encontraron ventas con los filtros aplicados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>