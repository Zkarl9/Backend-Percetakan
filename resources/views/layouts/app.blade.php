<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'INTAN EXCLUSIVE')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, #ef4444, #ec4899);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-item:hover::before,
        .nav-item.active::before {
            transform: scaleY(1);
        }

        .nav-item:hover {
            transform: translateX(4px);
            background: linear-gradient(to right, rgba(254, 226, 226, 0.5), transparent);
        }

        .nav-item.active {
            background: linear-gradient(to right, rgba(254, 226, 226, 0.8), rgba(252, 231, 243, 0.4));
            font-weight: 600;
        }

        .logo-container {
            animation: fadeIn 0.5s ease;
        }

        .user-badge {
            background: linear-gradient(135deg, #fef2f2 0%, #fce7f3 100%);
            border: 2px solid rgba(239, 68, 68, 0.1);
            transition: all 0.3s ease;
        }

        .user-badge:hover {
            border-color: rgba(239, 68, 68, 0.3);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        .mobile-header {
            background: linear-gradient(to right, #ffffff, #fef2f2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .sidebar {
            background: linear-gradient(to bottom, #ffffff 0%, #fefefe 100%);
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.05);
        }

        .icon-wrapper {
            transition: transform 0.3s ease;
        }

        .nav-item:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .nav-item.active .icon-wrapper {
            animation: pulse 2s ease-in-out infinite;
        }

        .burger-btn {
            transition: all 0.3s ease;
        }

        .burger-btn:hover {
            background: linear-gradient(135deg, #fef2f2, #fce7f3);
            transform: scale(1.05);
        }

        .overlay {
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
        }

        .logout-btn {
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            color: #dc2626;
            transform: translateX(4px);
        }

        .role-badge {
            background: linear-gradient(135deg, #fee2e2, #fce7f3);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #be123c;
            display: inline-block;
            margin-top: 2px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Error and Success Messages -->
    @if(session('error') || session('success') || $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        showConfirmButton: true,
                        timer: 3000,
                        customClass: {
                            confirmButton: 'bg-red-500 hover:bg-red-600'
                        }
                    });
                @endif

                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#fef2f2'
                    });
                @endif

                @if($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: "@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach",
                        showConfirmButton: true,
                        customClass: {
                            confirmButton: 'bg-red-500 hover:bg-red-600'
                        }
                    });
                @endif
            });
        </script>
    @endif
    
    @if(request()->routeIs('admin.*'))
    <script>
        // Catatan: Auto-refresh periodik dihapus — hanya tetapkan pembaruan waktu relatif setiap menit.

        // Update relative times setiap menit
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
    <script>
        window.onload = function() {
            if (window.history && window.history.pushState) {
                window.history.pushState('forward', null, window.location.pathname);
                window.onpopstate = function() {
                    window.history.pushState('forward', null, window.location.pathname);
                };
            }
        }

        // Toggle sidebar untuk mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar saat klik overlay
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>

    <div class="min-h-screen">
        @if(auth()->check() && request()->route()->getName() != 'login')
            <!-- Mobile Header with Burger Menu -->
            <div class="mobile-header lg:hidden fixed top-0 left-0 right-0 h-16 z-30 flex items-center justify-between px-4">
                <button onclick="toggleSidebar()" class="burger-btn p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img src="{{ asset('images/logo.png') }}" alt="Intan Exclusive" class="h-10">
                <div class="w-10"></div>
            </div>

            <!-- Overlay untuk mobile -->
            <div id="overlay" class="overlay hidden lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40" onclick="closeSidebar()"></div>

            <!-- Sidebar Navigation -->
            <nav id="sidebar" class="sidebar fixed top-0 left-0 h-full w-64 overflow-y-auto z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
                <!-- Close button untuk mobile -->
                <button onclick="closeSidebar()" class="lg:hidden absolute top-4 right-4 p-2 rounded-md hover:bg-red-50 transition-colors z-10">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Logo & Brand -->
                <div class="logo-container flex items-center justify-center h-20 px-4 bg-gradient-to-r from-white to-red-50">
                    <img src="{{ asset('images/logo.png') }}" alt="Intan Exclusive" class="h-16 drop-shadow-md">
                </div>

                <!-- User Info -->
                <div class="p-4">
                    <div class="user-badge flex items-center p-3 rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center shadow-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <span class="role-badge">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="py-4 px-2">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} block px-4 py-3 rounded-lg mb-1">
                        <div class="flex items-center">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-red-500' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span class="{{ request()->routeIs('dashboard') ? 'text-red-500' : 'text-gray-700' }}">Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('produk.index') }}" 
                       class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }} block px-4 py-3 rounded-lg mb-1">
                        <div class="flex items-center">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('produk.*') ? 'text-pink-500' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="{{ request()->routeIs('produk.*') ? 'text-pink-500' : 'text-gray-700' }}">Produk</span>
                        </div>
                    </a>

                    <a href="{{ route('ecommerce.index') }}" 
                       class="nav-item {{ request()->routeIs('ecommerce.*') ? 'active' : '' }} block px-4 py-3 rounded-lg mb-1">
                        <div class="flex items-center">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('ecommerce.*') ? 'text-pink-500' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="{{ request()->routeIs('ecommerce.*') ? 'text-pink-500' : 'text-gray-700' }}">E-Commerce</span>
                        </div>
                    </a>

                    @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.index') }}" 
                       class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }} block px-4 py-3 rounded-lg mb-1">
                        <div class="flex items-center">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.*') ? 'text-pink-500' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="{{ request()->routeIs('admin.*') ? 'text-pink-500' : 'text-gray-700' }}">Manage Admins</span>
                        </div>
                    </a>
                    @endif

                    <a href="{{ route('password.change') }}" 
                       class="nav-item {{ request()->routeIs('password.change') ? 'active' : '' }} block px-4 py-3 rounded-lg mb-1">
                        <div class="flex items-center">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('password.change') ? 'text-pink-500' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <span class="{{ request()->routeIs('password.change') ? 'text-pink-500' : 'text-gray-700' }}">Change Password</span>
                        </div>
                    </a>

                    <div class="my-4 border-t border-gray-200"></div>

                    <form method="POST" action="{{ route('logout') }}" class="block px-4 py-3">
                        @csrf
                        <button type="submit" class="logout-btn flex items-center w-full text-left text-gray-700">
                            <div class="icon-wrapper">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <span class="font-medium">Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="lg:ml-64 pt-16 lg:pt-0">
                @yield('content')
            </div>
        @else
            @yield('content')
        @endif
    </div>
    @stack('scripts')
</body>
</html>