<x-admin-layout>
    @section('title', 'Dashboard')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="p-4 bg-primary rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 1.1.9 2 2 2h12a2 2 0 002-2V7M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total de Productos</p>
                        <p class="text-2xl font-bold">54</p> </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                 <div class="flex items-center">
                    <div class="p-4 bg-success rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Ventas del Día</p>
                        <p class="text-2xl font-bold">$1,250.00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                 <div class="flex items-center">
                    <div class="p-4 bg-info rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a3.001 3.001 0 015.644 0M12 12a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Nuevos Usuarios</p>
                        <p class="text-2xl font-bold">8</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                 <div class="flex items-center">
                    <div class="p-4 bg-warning rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Pedidos Pendientes</p>
                        <p class="text-2xl font-bold">3</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>