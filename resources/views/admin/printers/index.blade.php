<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Configuración de Impresora') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200 border-b border-gray-700">
                    <form action="{{ route('admin.printers.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="printer_ip" class="block text-sm font-medium text-gray-300">IP de la Impresora</label>
                            <div class="mt-1">
                                <input type="text" name="printer_ip" id="printer_ip" value="{{ old('printer_ip', $printerIp->value ?? '') }}" class="bg-gray-900 text-gray-300 border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md" required>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                             <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 mr-2">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>