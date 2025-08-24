<!-- PASO 6: Reemplaza la vista de tu POS para asegurar que la comunicación sea correcta. -->
<!-- archivo: resources/views/pos/index.blade.php -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="night">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Punto de Venta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="[https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css)" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .h-screen-pos { height: 100vh; }
        .notification-banner {
            transition: opacity 0.5s ease-in-out;
        }
        @media print {
            body * { visibility: hidden; }
            #print-section, #print-section * { visibility: visible; }
            #print-section { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="h-screen-pos flex flex-col">
        <!-- Header -->
        <header class="bg-base-100 shadow-md p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Punto de Venta</h1>
            @if(Auth::user()->role === 'Admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-primary">Ir al Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline btn-error">Cerrar Sesión</button>
            </form>
        </header>

        <!-- Main Content -->
        <div class="flex-grow grid grid-cols-1 xl:grid-cols-3 gap-4 p-4 overflow-hidden">
            
            <!-- Products Section -->
            <div class="xl:col-span-2 bg-base-100 rounded-lg shadow-lg overflow-y-auto p-4">
                <!-- Category Buttons -->
                <div id="category-buttons" class="flex flex-wrap gap-2 mb-4">
                    @foreach($categories as $index => $category)
                        <button class="btn category-btn {{ $index === 0 ? 'btn-primary' : '' }}" data-target-panel="panel-{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Product Panels Container -->
                <div id="product-panels">
                    @foreach($categories as $index => $category)
                        <div id="panel-{{ $category->id }}" class="product-panel {{ $index !== 0 ? 'hidden' : '' }}">
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                @foreach($category->subcategories as $subcategory)
                                    @if($subcategory->products->isNotEmpty())
                                        <div class="card card-compact bg-base-200 shadow-xl cursor-pointer" onclick="showSizeSelectionModal({{ $subcategory->load('products')->toJson() }})">
                                            <figure class="bg-base-300">
                                                <img src="{{ $subcategory->url_img ?? '[https://placehold.co/200x150/192231/9ca3af?text=](https://placehold.co/200x150/192231/9ca3af?text=)' . urlencode($subcategory->name) . '&font-size=16' }}" alt="{{ $subcategory->name }}" class="h-32 sm:h-48 object-cover w-full" />
                                            </figure>
                                            <div class="card-body text-center p-2">
                                                <h2 class="card-title text-sm justify-center">{{ $subcategory->name }}</h2>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Section -->
            <div class="xl:col-span-1 bg-base-100 rounded-lg shadow-lg flex flex-col p-4">
                <div id="notification-container" class="mb-2"></div>
                <h2 id="order-title" class="text-xl font-bold mb-4">Orden Actual</h2>
                <input type="text" id="customer-name" placeholder="Nombre del Cliente o Mesa" class="input input-bordered w-full mb-4">
                <div id="order-items" class="flex-grow overflow-y-auto space-y-2">
                    <p class="text-gray-400 text-center pt-8">Añade productos a la orden.</p>
                </div>
                <div class="border-t border-base-300 pt-4 mt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span id="order-total">$0.00</span>
                    </div>
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <button class="btn btn-accent" onclick="saveOrder()"><i class="fas fa-save mr-2"></i>Guardar</button>
                        <button class="btn btn-secondary" onclick="printComanda()"><i class="fas fa-print mr-2"></i>Comanda</button>
                        <button class="btn btn-info" onclick="printPreview()"><i class="fas fa-print mr-2"></i>Imprimir/Prueba</button>
                        <button class="btn btn-primary" onclick="showPaymentModal()"><i class="fas fa-dollar-sign mr-2"></i>Cobrar</button>
                    </div>
                    <button class="btn btn-ghost w-full mt-2" onclick="newOrder()"><i class="fas fa-plus mr-2"></i>Nueva Orden</button>
                </div>
                 <!-- Saved Orders Section -->
                <div class="border-t border-base-300 pt-4 mt-4">
                    <h3 class="font-bold mb-2">Órdenes Guardadas</h3>
                    <div id="saved-orders-container" class="space-y-2 max-h-32 overflow-y-auto">
                        <p class="text-gray-500 text-sm">No hay órdenes guardadas.</p>
                    </div>
                </div>
                <div id="print-preview-container" class="mt-4"></div>
            </div>
        </div>
    </div>

    <!-- Size Selection Modal -->
    <dialog id="size_modal" class="modal">
        <div class="modal-box">
            <h3 id="modal-title" class="font-bold text-lg">Seleccionar Tamaño</h3>
            <div id="modal-sizes-container" class="py-4 grid grid-cols-1 gap-2"></div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cerrar</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Payment Modal -->
    <dialog id="payment_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Procesar Pago</h3>
            <p class="py-4 text-2xl">Total a Pagar: <span id="payment-total" class="font-bold text-primary"></span></p>

            <div class="tabs tabs-boxed mb-4">
                <a id="cash-tab" class="tab tab-active" onclick="selectPaymentMethod('cash')">Efectivo</a> 
                <a id="card-tab" class="tab" onclick="selectPaymentMethod('card')">Tarjeta</a> 
            </div>

            <!-- Cash Payment Section -->
            <div id="cash-details" class="space-y-4">
                <div>
                    <label for="amount-paid" class="label">Monto Recibido:</label>
                    <input type="number" id="amount-paid" class="input input-bordered w-full" placeholder="0.00" oninput="calculateChange()">
                </div>
                <p class="text-lg">Cambio: <span id="change-due" class="font-bold text-xl">$0.00</span></p>
                <button class="btn btn-secondary w-full" onclick="setExactChange()">Pago Exacto</button>
            </div>

            <div class="modal-action">
                 <button class="btn btn-success" onclick="finalizeSale()">Finalizar Venta</button>
                 <form method="dialog"><button class="btn">Cancelar</button></form>
            </div>
        </div>
    </dialog>

    <div id="print-section" class="hidden"></div>

    <script>
        let currentOrder = [];
        let savedOrders = {};
        let originalLoadedOrderState = null;
        let selectedPaymentMethod = 'cash';

        const orderItemsContainer = document.getElementById('order-items');
        const orderTotalElement = document.getElementById('order-total');
        const customerNameInput = document.getElementById('customer-name');
        const savedOrdersContainer = document.getElementById('saved-orders-container');
        const orderTitle = document.getElementById('order-title');
        const notificationContainer = document.getElementById('notification-container');
        const printPreviewContainer = document.getElementById('print-preview-container');
        const printSection = document.getElementById('print-section');
        
        const sizeModal = document.getElementById('size_modal');
        const modalTitle = document.getElementById('modal-title');
        const modalSizesContainer = document.getElementById('modal-sizes-container');

        const paymentModal = document.getElementById('payment_modal');
        const paymentTotalElement = document.getElementById('payment-total');
        const cashDetails = document.getElementById('cash-details');
        const amountPaidInput = document.getElementById('amount-paid');
        const changeDueElement = document.getElementById('change-due');

        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const productPanels = document.querySelectorAll('.product-panel');
            categoryButtons.forEach(button => {
                button.addEventListener('click', () => {
                    categoryButtons.forEach(btn => btn.classList.remove('btn-primary'));
                    button.classList.add('btn-primary');
                    const targetPanelId = button.dataset.targetPanel;
                    productPanels.forEach(panel => panel.classList.add('hidden'));
                    document.getElementById(targetPanelId).classList.remove('hidden');
                });
            });
        });

        function showNotification(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            const notification = document.createElement('div');
            notification.className = `alert ${alertClass} notification-banner`;
            notification.innerHTML = `<span>${message}</span>`;
            notificationContainer.appendChild(notification);
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        function showSizeSelectionModal(subcategory) {
            modalTitle.textContent = `Seleccionar tamaño para ${subcategory.name}`;
            modalSizesContainer.innerHTML = '';
            subcategory.products.forEach(product => {
                const button = document.createElement('button');
                button.classList.add('btn', 'btn-outline', 'w-full');
                button.textContent = `${product.size_oz} oz - $${parseFloat(product.price).toFixed(2)}`;
                button.onclick = () => addToOrderAndCloseModal(product);
                modalSizesContainer.appendChild(button);
            });
            sizeModal.showModal();
        }
        
        function addToOrderAndCloseModal(product) {
            addToOrder(product);
            sizeModal.close();
        }

        function addToOrder(product) {
            const existingProduct = currentOrder.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                currentOrder.push({ ...product, quantity: 1 });
            }
            renderOrder();
        }

        function renderOrder() {
            orderItemsContainer.innerHTML = '';
            if (currentOrder.length === 0) {
                orderItemsContainer.innerHTML = '<p class="text-gray-400 text-center pt-8">Añade productos a la orden.</p>';
            } else {
                currentOrder.forEach((item, index) => {
                    const itemElement = document.createElement('div');
                    itemElement.classList.add('flex', 'justify-between', 'items-center', 'bg-base-200', 'p-2', 'rounded-lg');
                    itemElement.innerHTML = `
                        <div>
                            <p class="font-semibold">${item.name} (${item.size_oz} oz)</p>
                            <p class="text-sm text-gray-400">$${parseFloat(item.price).toFixed(2)}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="btn btn-xs btn-outline" onclick="updateQuantity(${index}, -1)">-</button>
                            <span>${item.quantity}</span>
                            <button class="btn btn-xs btn-outline" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemElement);
                });
            }
            updateTotal();
        }
        
        function updateQuantity(index, change) {
            currentOrder[index].quantity += change;
            if (currentOrder[index].quantity <= 0) {
                currentOrder.splice(index, 1);
            }
            renderOrder();
        }

        function updateTotal() {
            const total = currentOrder.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            orderTotalElement.textContent = `$${total.toFixed(2)}`;
            return total;
        }

        function saveOrder() {
            const customerName = customerNameInput.value.trim();
            if (!customerName) {
                showNotification('Introduce un nombre para guardar la orden.', 'error');
                return;
            }
            if (currentOrder.length === 0) {
                showNotification('No hay productos en la orden para guardar.', 'error');
                return;
            }
            savedOrders[customerName] = JSON.parse(JSON.stringify(currentOrder));
            renderSavedOrders();
            showNotification(`Orden para "${customerName}" guardada.`, 'success');
            newOrder();
        }

        function newOrder() {
            currentOrder = [];
            customerNameInput.value = '';
            originalLoadedOrderState = null;
            orderTitle.textContent = 'Orden Actual';
            renderOrder();
        }

        function renderSavedOrders() {
            savedOrdersContainer.innerHTML = '';
            const names = Object.keys(savedOrders);
            if (names.length === 0) {
                savedOrdersContainer.innerHTML = '<p class="text-gray-500 text-sm">No hay órdenes guardadas.</p>';
                return;
            }
            names.forEach(name => {
                const orderTotal = savedOrders[name].reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const button = document.createElement('button');
                button.classList.add('btn', 'btn-sm', 'w-full', 'justify-start');
                button.innerHTML = `
                    <span class="flex-grow text-left">${name}</span>
                    <span class="font-bold">$${orderTotal.toFixed(2)}</span>
                `;
                button.onclick = () => loadOrder(name);
                savedOrdersContainer.appendChild(button);
            });
        }

        function loadOrder(name) {
            currentOrder = JSON.parse(JSON.stringify(savedOrders[name]));
            originalLoadedOrderState = JSON.parse(JSON.stringify(savedOrders[name]));
            customerNameInput.value = name;
            orderTitle.textContent = `Orden de: ${name}`;
            delete savedOrders[name];
            renderOrder();
            renderSavedOrders();
            showNotification(`Orden de "${name}" cargada.`, 'success');
        }

        async function printComanda() {
            const customerName = customerNameInput.value.trim() || 'Cliente';
            let itemsToPrint = [];
            
            if (originalLoadedOrderState) {
                const originalQuantities = originalLoadedOrderState.reduce((acc, item) => {
                    acc[item.id] = item.quantity;
                    return acc;
                }, {});

                currentOrder.forEach(item => {
                    const originalQty = originalQuantities[item.id] || 0;
                    if (item.quantity > originalQty) {
                        itemsToPrint.push({ ...item, quantity: item.quantity - originalQty });
                    }
                });
            } else {
                itemsToPrint = currentOrder;
            }

            if (itemsToPrint.length === 0) {
                showNotification('No hay productos nuevos para imprimir.', 'error');
                return;
            }

            // ¡Aquí está la magia!
            try {
                const response = await fetch("{{ route('admin.print.ticket') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        customer_name: customerName,
                        items_to_print: itemsToPrint
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                showNotification('Error de conexión al intentar imprimir.', 'error');
            }
        }

        function printPreview() {
            if (currentOrder.length === 0) {
                showNotification('No hay productos en la orden para imprimir.', 'error');
                return;
            }

            const customerName = customerNameInput.value.trim() || 'Cliente';
            const total = updateTotal();
            const itemsHtml = currentOrder.map(item => `<li>${item.quantity} x ${item.name}</li>`).join('');
            const previewHtml = `
                <div class="card bg-base-200 shadow-md p-4">
                    <h3 class="font-bold mb-2">Vista previa de impresión</h3>
                    <p class="text-sm mb-2"><strong>Cliente:</strong> ${customerName}</p>
                    <ul class="text-sm space-y-1">${itemsHtml}</ul>
                    <p class="mt-2 font-bold">Total: $${total.toFixed(2)}</p>
                </div>
            `;

            printPreviewContainer.innerHTML = previewHtml;
            printSection.innerHTML = previewHtml;
            window.print();
        }

        // --- Payment Modal Logic ---
        function showPaymentModal() {
            if (currentOrder.length === 0) {
                showNotification('No hay productos en la orden para cobrar.', 'error');
                return;
            }
            const total = updateTotal();
            paymentTotalElement.textContent = `$${total.toFixed(2)}`;
            selectPaymentMethod('cash'); // Reset to cash by default
            amountPaidInput.value = '';
            changeDueElement.textContent = '$0.00';
            paymentModal.showModal();
        }

        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;
            const cashTab = document.getElementById('cash-tab');
            const cardTab = document.getElementById('card-tab');

            if (method === 'cash') {
                cashDetails.style.display = 'block';
                cashTab.classList.add('tab-active');
                cardTab.classList.remove('tab-active');
            } else {
                cashDetails.style.display = 'none';
                cashTab.classList.remove('tab-active');
                cardTab.classList.add('tab-active');
            }
        }

        function calculateChange() {
            const total = updateTotal();
            const paid = parseFloat(amountPaidInput.value) || 0;
            const change = paid - total;
            changeDueElement.textContent = `$${change >= 0 ? change.toFixed(2) : '0.00'}`;
        }

        function setExactChange() {
            const total = updateTotal();
            amountPaidInput.value = total.toFixed(2);
            calculateChange();
        }

        async function finalizeSale() {
            const total = updateTotal();
            const payload = {
                customer_name: customerNameInput.value.trim() || 'Cliente',
                total_price: total,
                payment_method: selectedPaymentMethod,
                items: currentOrder,
            };

            try {
                const response = await fetch("{{ route('admin.orders.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification('Venta finalizada con éxito.', 'success');
                    paymentModal.close();
                    newOrder();
                } else {
                    showNotification(result.message || 'Hubo un error al guardar la venta.', 'error');
                }
            } catch (error) {
                showNotification('Error de conexión al guardar la venta.', 'error');
            }
        }
    </script>
</body>
</html>
