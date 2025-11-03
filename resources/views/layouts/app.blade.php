<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Admin System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

    {{-- Auto refresh hanya di halaman admin --}}
    @if(request()->routeIs('admin.*'))
    <script>
        setInterval(function() {
            window.location.reload();
        }, 30000);

        setInterval(function() {
            document.querySelectorAll('[data-last-active]').forEach(function(el) {
                const timestamp = el.getAttribute('data-last-active');
                if (timestamp) {
                    const date = new Date(timestamp);
                    const now = new Date();
                    const diffInSeconds = Math.floor((now - date) / 1000);
                    let timeAgo;
                    if (diffInSeconds < 60) {
                        timeAgo = 'just now';
                    } else if (diffInSeconds < 3600) {
                        const minutes = Math.floor(diffInSeconds / 60);
                        timeAgo = minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
                    } else if (diffInSeconds < 86400) {
                        const hours = Math.floor(diffInSeconds / 3600);
                        timeAgo = hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
                    } else {
                        const days = Math.floor(diffInSeconds / 86400);
                        timeAgo = days + ' day' + (days > 1 ? 's' : '') + ' ago';
                    }
                    el.textContent = timeAgo;
                }
            });
        }, 60000);
    </script>
    @endif

    {{-- Cegah tombol back setelah logout --}}
    <script>
        window.onload = function() {
            if (window.history && window.history.pushState) {
                window.history.pushState('forward', null, window.location.pathname);
                window.onpopstate = function() {
                    window.history.pushState('forward', null, window.location.pathname);
                };
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex">

        {{-- Sidebar tampil jika user login dan bukan di halaman login --}}
        @if(request()->route()->getName() != 'login')
            @auth
            {{-- Sidebar --}}
            <aside class="w-64 bg-white rounded-r-2xl shadow-sm flex flex-col justify-between">
                <div>
                    {{-- Logo --}}
                    <div class="flex items-center p-4 border-b">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain mr-2">
                        <div>
                            <p class="font-semibold text-gray-800 leading-tight">INTAN</p>
                            <p class="font-semibold text-gray-800 leading-tight">EXCLUSIVE</p>
                        </div>
                    </div>

                    {{-- Info User --}}
                    <div class="p-4 border-b">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <i class="fa-solid fa-user text-indigo-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Menu Navigasi --}}
                    <nav class="flex flex-col gap-1 p-4 text-sm font-medium">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                           {{ request()->routeIs('dashboard') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('produk.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                           {{ request()->routeIs('produk.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-box"></i>
                            Produk
                        </a>

                        <a href="{{ route('ecommerce.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                           {{ request()->routeIs('ecommerce.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            E-commerce
                        </a>

                        {{-- Hanya tampil jika role superadmin --}}
                        @if(Auth::user()->role === 'superadmin')
                        <a href="{{ route('admin.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                           {{ request()->routeIs('admin.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            Manajemen Admin
                        </a>
                        @endif

                        <a href="{{ route('password.change') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md transition
                           {{ request()->routeIs('password.change') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-lock"></i>
                            Ganti Password
                        </a>
                    </nav>
                </div>

                {{-- Tombol Logout --}}
                <div class="border-t p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-3 text-gray-700 hover:text-red-500 transition text-sm font-medium">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </aside>
            @endauth
        @endif

        {{-- Konten utama --}}
        <main class="flex-1 p-8">
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Konten halaman --}}
            @yield('content')
        </main>
    </div>
</body>
</html>
