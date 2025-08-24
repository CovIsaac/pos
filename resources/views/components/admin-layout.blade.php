<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="night">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-200">
        <div class="drawer lg:drawer-open">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col items-start justify-start p-6">
                <div class="w-full">
                    <div class="flex justify-between items-center mb-6">
                        <div class="text-3xl font-bold text-base-content">
                             @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>
                        <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">Menu</label>
                    </div>
                    @if (session('success'))
                        <div role="alert" class="alert alert-success mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
            <div class="drawer-side">
                <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
                <ul class="menu p-4 w-80 min-h-full bg-base-100 text-base-content">
                    <li class="text-xl font-bold p-4"><a>POS Admin</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">Ir al POS</a></li>
                    <div class="divider"></div>
                    <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categorías</a></li>
                    <li><a href="{{ route('admin.subcategories.index') }}" class="{{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">Subcategorías</a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Productos</a></li>
                    <li><a href="{{ route('admin.printers.index') }}" class="{{ request()->routeIs('admin.printers.*') ? 'active' : '' }}">Impresora</a></li>
                    <div class="divider"></div>

                    <li>
                        <details open>
                              <summary>
                                  {{ Auth::user()->name }}
                              </summary>
                              <ul>
                                  <li><a href="{{ route('profile.edit') }}">Perfil</a></li>
                                  <li>
                                      <form method="POST" action="{{ route('logout') }}">
                                          @csrf
                                          <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                              Cerrar Sesión
                                          </a>
                                      </form>
                                  </li>
                              </ul>
                        </details>
                      </li>
                </ul>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>