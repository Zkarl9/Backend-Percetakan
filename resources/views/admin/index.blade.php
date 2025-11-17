@extends('layouts.app')

@section('title', 'Manage Admins')

@section('content')

<style>
    /* CSS Sederhana untuk tampilan bersih */
    .simple-header-bg {
        background-color: #f3f4f6; /* Gray 100 */
    }

    .simple-card {
        background-color: white;
        border: 1px solid #e5e7eb; /* Gray 200 */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    }

    .btn-primary-simple {
        background-color: #4f46e5; /* Indigo 600 */
        transition: background-color 0.15s ease-in-out;
    }

    .btn-primary-simple:hover {
        background-color: #4338ca; /* Indigo 700 */
    }

    .table-row-hover:hover {
        background-color: #f9fafb; /* Gray 50 */
    }

    /* Modal Styling Sederhana */
    .modal-overlay-simple {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4); /* Darker, simpler backdrop */
        z-index: 50;
        overflow-y: auto;
        padding: 1rem;
    }

    .modal-overlay-simple.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content-simple {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 42rem;
        max-height: 90vh;
        overflow-y: auto;
    }

    .form-input-simple {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db; /* Gray 300 */
        border-radius: 0.5rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-input-simple:focus {
        outline: none;
        border-color: #4f46e5; /* Indigo 600 */
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
</style>

<div class="simple-header-bg py-16 px-6 mb-10 rounded-lg shadow-md">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2 tracking-tight">
            👥 Manajemen Administrator
        </h1>
        <p class="text-gray-600 text-lg font-medium max-w-2xl mx-auto">
            Kelola akses dan status administrator sistem.
        </p>
    </div>
</div>

<div class="container mx-auto px-6 pb-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="simple-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wider">Total Admins</p>
                    <p class="text-4xl font-bold text-gray-900">{{ count($admins) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-2xl">
                    👤
                </div>
            </div>
        </div>

        <div class="simple-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wider">Active</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $admins->where('is_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl">
                    ✅
                </div>
            </div>
        </div>

        <div class="simple-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wider">Inactive</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $admins->where('is_active', false)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 text-2xl">
                    ⛔
                </div>
            </div>
        </div>
    </div>

    <div class="simple-card rounded-xl overflow-hidden">
        <div class="bg-gray-50 p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="text-3xl text-indigo-600">🔐</span>
                        Daftar Administrator
                    </h2>
                    <p class="text-gray-500 text-sm">Kelola administrator dan status akses mereka.</p>
                </div>
                <button onclick="openModal()" class="btn-primary-simple text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Admin
                </button>
            </div>
        </div>

        <div class="p-6">
            @if(count($admins) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                            <th class="py-3 px-6 text-left font-bold">Administrator</th>
                            <th class="py-3 px-6 text-left font-bold">Status</th>
                            <th class="py-3 px-6 text-left font-bold">Last Active</th>
                            <th class="py-3 px-6 text-left font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light divide-y divide-gray-200">
                        @foreach($admins as $admin)
                        <tr class="table-row-hover">
                            <td class="py-4 px-6 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white text-base font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate mb-0.5">
                                            {{ $admin->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 truncate">{{ $admin->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 align-middle">
                                @if($admin->isActive())
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 align-middle">
                                @if($admin->last_login)
                                    <span 
                                        title="{{ $admin->last_login->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}"
                                        class="text-xs text-gray-700 whitespace-nowrap"
                                    >
                                        {{ $admin->last_login->diffForHumans() }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic whitespace-nowrap">
                                        Never
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 align-middle">
                                <form action="{{ route('admin.toggle-status', $admin) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-white px-4 py-2 rounded-lg text-xs font-semibold shadow-sm transition duration-150 ease-in-out
                                        {{ $admin->isActive() 
                                            ? 'bg-red-500 hover:bg-red-600' 
                                            : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $admin->isActive() ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-12 text-center bg-gray-50 rounded-lg border border-dashed border-gray-200">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-3xl text-indigo-600">
                        👥
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Belum ada administrator</h3>
                        <p class="text-gray-500 mb-4 text-sm">Klik tombol di bawah untuk menambahkan administrator pertama Anda.</p>
                    </div>
                    <button onclick="openModal()" class="btn-primary-simple text-white px-6 py-3 rounded-lg text-sm font-semibold shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Admin Pertama
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="createAdminModal" class="modal-overlay-simple" onclick="closeModalOnOutsideClick(event)">
    <div class="modal-content-simple">
        <div class="bg-indigo-600 p-6 rounded-t-xl text-white flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-bold mb-1 flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Administrator Baru
                </h3>
                <p class="text-sm opacity-90">Isi informasi akun administrator baru.</p>
            </div>
            <button type="button" onclick="closeModal()" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="form-input-simple @error('name') border-red-500 @enderror"
                        placeholder="Contoh: John Doe">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="form-input-simple @error('email') border-red-500 @enderror"
                        placeholder="admin@example.com">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" required
                        class="form-input-simple @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="form-input-simple"
                        placeholder="Ulangi Kata Sandi">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition shadow-sm">
                    Batal
                </button>
                <button type="submit" class="btn-primary-simple text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md">
                    Simpan Admin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsionalitas Modal Sederhana (hanya JS)
    function openModal() {
        document.getElementById('createAdminModal').classList.add('active');
    }

    function closeModal() {
        document.getElementById('createAdminModal').classList.remove('active');
        // Bersihkan error state jika ada
        const errorInputs = document.querySelectorAll('.form-input-simple.border-red-500');
        errorInputs.forEach(input => input.classList.remove('border-red-500'));
        const errorMessages = document.querySelectorAll('.text-red-500');
        errorMessages.forEach(msg => msg.remove());

        // Reset form
        document.querySelector('#createAdminModal form').reset();
    }

    function closeModalOnOutsideClick(event) {
        const modalOverlay = document.getElementById('createAdminModal');
        const modalContent = document.querySelector('.modal-content-simple');
        if (event.target === modalOverlay) {
            closeModal();
        }
    }

    // Tampilkan modal jika ada error validasi dari Laravel
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            openModal();
        });
    @endif
</script>

@endsection