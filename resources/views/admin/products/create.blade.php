<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Category</label>
                <select name="subcategory_id" class="mt-1 block w-full rounded-md" required>
                    <option value="">Select...</option>
                    @foreach ($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach ($category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @selected(old('subcategory_id') == $subcategory->id)>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Sizes & Prices</label>
                <table id="sizes-table" class="w-full text-sm border mt-1">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Size</th>
                            <th class="p-2">Price</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-2"><input type="text" name="sizes[0][name]" class="w-full rounded-md"></td>
                            <td class="p-2"><input type="number" step="0.01" name="sizes[0][price]" class="w-full rounded-md"></td>
                            <td class="p-2 text-center"><button type="button" class="remove-row text-red-500">✕</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add-size" class="mt-2 px-3 py-1 bg-gray-200 rounded">Add Size</button>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Image</label>
                <div id="drop-zone" class="mt-1 flex items-center justify-center w-full h-32 border-2 border-dashed rounded-md cursor-pointer">
                    <span>Drop image here or click to upload</span>
                </div>
                <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700 mb-1">Extras</label>
                <div class="space-y-1">
                    @foreach ($extras as $extra)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="extras[]" value="{{ $extra->id }}">
                            <span>{{ $extra->name }} (${{ number_format($extra->price, 2) }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>

    <script>
        let sizeIndex = 1;
        document.getElementById('add-size').addEventListener('click', function () {
            const tbody = document.querySelector('#sizes-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="p-2"><input type="text" name="sizes[${sizeIndex}][name]" class="w-full rounded-md"></td>
                <td class="p-2"><input type="number" step="0.01" name="sizes[${sizeIndex}][price]" class="w-full rounded-md"></td>
                <td class="p-2 text-center"><button type="button" class="remove-row text-red-500">✕</button></td>
            `;
            tbody.appendChild(row);
            sizeIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });

        const dropZone = document.getElementById('drop-zone');
        const imageInput = document.getElementById('image-input');
        dropZone.addEventListener('click', () => imageInput.click());
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-gray-100');
        });
        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-gray-100');
        });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-gray-100');
            imageInput.files = e.dataTransfer.files;
        });
    </script>
</x-app-layout>
