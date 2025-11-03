<div class="flex flex-col justify-between w-64 h-screen bg-white rounded-2xl p-4 shadow-sm">

    {{-- Logo --}}
    <div>
        <div class="flex items-center mb-10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain mr-2">
            <div>
                <p class="font-semibold text-gray-800 leading-tight">INTAN</p>
                <p class="font-semibold text-gray-800 leading-tight">EXCLUSIVE</p>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium transition 
               {{ request()->routeIs('dashboard') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>

            <a href="{{ route('produk.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium transition 
               {{ request()->routeIs('produk.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fa-solid fa-box"></i>
                Produk
            </a>

            <a href="{{ route('ecommerce.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium transition 
               {{ request()->routeIs('ecommerce.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fa-solid fa-cart-shopping"></i>
                E-commerce
            </a>

            {{-- Tampilkan hanya jika role user = superadmin --}}
            @if(Auth::user() && Auth::user()->role === 'superadmin')
                <a href="{{ route('admin.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium transition 
                   {{ request()->routeIs('admin.*') ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-user"></i>
                    Manajemen Admin
                </a>
            @endif
        </nav>
    </div>

    {{-- Logout --}}
    <div class="border-t pt-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 text-gray-700 hover:text-red-500 transition text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket"></i>
                Log out
            </button>
        </form>
    </div>

</div>