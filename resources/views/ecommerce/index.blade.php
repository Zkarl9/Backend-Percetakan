@extends('layouts.app')

@section('title', 'E-Commerce')

@section('content')

<style>
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.3s ease-out;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.5);
    }

    .input-modern {
        transition: all 0.3s ease;
    }

    .input-modern:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.2);
    }

    .table-row-hover {
        transition: all 0.2s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        transform: scale(1.01);
    }

    .icon-bounce {
        transition: transform 0.3s ease;
    }

    .icon-bounce:hover {
        transform: scale(1.2) rotate(10deg);
    }

    .gradient-text {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .platform-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .modal-backdrop {
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        animation: scaleIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .link-preview {
        position: relative;
        overflow: hidden;
    }

    .link-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .link-preview:hover::before {
        left: 100%;
    }

    .platform-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #eff6ff 0%, #f3e8ff 100%);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Header dengan Gradient Background -->
<div class="gradient-bg py-16 px-6 mb-8 rounded-3xl shadow-2xl animate-slide-up">
    <div class="container mx-auto text-center">
        <h1 class="text-5xl font-bold text-white mb-4 floating">🛒 Manajemen E-Commerce</h1>
        <p class="text-white text-lg opacity-90">Kelola link marketplace dan platform jualan Anda</p>
    </div>
</div>

<div class="container mx-auto px-6 pb-12">
    <!-- Card Container dengan Glass Effect -->
    <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden animate-scale-in">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 border-b-4 border-blue-300">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold gradient-text mb-2">🏪 Daftar Platform</h2>
                    <p class="text-gray-600">Total: <span class="font-semibold text-blue-600">{{ count($ecommerce) }}</span> platform</p>
                </div>
                <button onclick="openModal('add')" class="btn-gradient text-white px-8 py-4 rounded-2xl text-base font-semibold shadow-lg flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah E-Commerce
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-100 to-purple-100">
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tl-2xl">No</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Platform</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">URL/Link E-Commerce</th>
                            <th class="px-8 py-5 text-center text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y-2 divide-gray-100">
                        @forelse($ecommerce as $index => $item)
                        <tr class="table-row-hover">
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 text-white font-bold shadow-md">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="platform-icon">
                                        🛍️
                                    </div>
                                    <span class="platform-badge">
                                        {{ $item->platform }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <a href="{{ $item->url_link }}" target="_blank" class="link-preview inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium underline decoration-2 underline-offset-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    {{ Str::limit($item->url_link, 50) }}
                                </a>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center gap-3">
                                    <button type="button" 
                                            onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->platform) }}', '{{ $item->url_link }}')" 
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl icon-bounce" 
                                            title="Edit Platform">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick="confirmDelete({{ $item->id }})" 
                                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white p-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl icon-bounce" 
                                            title="Hapus Platform">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('ecommerce.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center text-5xl">
                                        🛒
                                    </div>
                                    <p class="text-xl font-semibold text-gray-600">Belum ada platform e-commerce</p>
                                    <p class="text-gray-500">Tambahkan platform jualan pertama Anda!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH E-COMMERCE -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="modal-backdrop fixed inset-0 bg-gradient-to-br from-blue-900/50 to-purple-900/50" aria-hidden="true"></div>
        
        <div class="modal-content relative transform overflow-hidden rounded-3xl bg-white shadow-2xl transition-all w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl">
                            ➕
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">Tambah E-Commerce</h3>
                            <p class="text-blue-100 mt-1">Tambahkan platform marketplace baru</p>
                        </div>
                    </div>
                    <button onclick="closeModal('add')" class="text-white hover:bg-white/20 p-2 rounded-full transition-all duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-6">
                <form id="addEcommerceForm" onsubmit="submitForm(event, 'add')" class="space-y-6">
                    @csrf
                    
                    <!-- Platform Selection -->
                    <div>
                        <label for="platform" class="block text-gray-700 font-semibold mb-3 flex items-center gap-2 text-base">
                            <span class="text-2xl">🏪</span>
                            Platform E-Commerce
                        </label>
                        <select name="platform" id="platform" class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 px-4 py-3 transition-all duration-300" required>
                            <option value="">Pilih Platform</option>
                            <optgroup label="🛍️ E-Commerce Indonesia">
                                <option value="Tokopedia">Tokopedia</option>
                                <option value="Shopee">Shopee</option>
                                <option value="Lazada">Lazada Indonesia</option>
                                <option value="Bukalapak">Bukalapak</option>
                                <option value="BliBli">BliBli</option>
                                <option value="JD.id">JD.id</option>
                                <option value="Zalora Indonesia">Zalora Indonesia</option>
                                <option value="Bhinneka">Bhinneka</option>
                                <option value="Elevenia">Elevenia</option>
                                <option value="Orami">Orami</option>
                            </optgroup>
                            <optgroup label="📱 Social Commerce">
                                <option value="Facebook Marketplace">Facebook Marketplace</option>
                                <option value="Instagram Shop">Instagram Shop</option>
                                <option value="TikTok Shop">TikTok Shop</option>
                                <option value="WhatsApp Business">WhatsApp Business</option>
                            </optgroup>
                            <optgroup label="🌐 Lainnya">
                                <option value="custom">Platform Lainnya...</option>
                            </optgroup>
                        </select>
                        <input type="text" id="customPlatform" name="customPlatform" class="mt-3 w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 px-4 py-3 shadow-sm transition-all duration-300 hidden" placeholder="Masukkan nama platform...">
                        <span id="platformError" class="text-red-500 text-sm mt-2 hidden flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="platformErrorText"></span>
                        </span>
                    </div>

                    <!-- URL Input -->
                    <div>
                        <label for="url_link" class="block text-gray-700 font-semibold mb-3 flex items-center gap-2 text-base">
                            <span class="text-2xl">🔗</span>
                            URL/Link E-Commerce
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <input type="url" name="url_link" id="url_link" class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 pl-12 pr-4 py-3 transition-all duration-300" placeholder="https://tokopedia.com/namaToko" required>
                        </div>
                        <span id="urlError" class="text-red-500 text-sm mt-2 hidden flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="urlErrorText"></span>
                        </span>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t-2 border-gray-100">
                <button type="button" onclick="closeModal('add')" class="px-8 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg">
                    Batal
                </button>
                <button type="submit" form="addEcommerceForm" class="btn-gradient text-white px-8 py-3 rounded-xl font-semibold shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT E-COMMERCE -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="modal-backdrop fixed inset-0 bg-gradient-to-br from-blue-900/50 to-purple-900/50" aria-hidden="true"></div>
        
        <div class="modal-content relative transform overflow-hidden rounded-3xl bg-white shadow-2xl transition-all w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl">
                            ✏️
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">Edit E-Commerce</h3>
                            <p class="text-green-100 mt-1">Perbarui informasi platform</p>
                        </div>
                    </div>
                    <button onclick="closeModal('edit')" class="text-white hover:bg-white/20 p-2 rounded-full transition-all duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-6">
                <form id="editEcommerceForm" method="POST" onsubmit="submitForm(event, 'edit')" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editId" name="id">
                    
                    <!-- Platform Selection -->
                    <div>
                        <label for="editPlatform" class="block text-gray-700 font-semibold mb-3 flex items-center gap-2 text-base">
                            <span class="text-2xl">🏪</span>
                            Platform E-Commerce
                        </label>
                        <select name="platform" id="editPlatform" class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-200 px-4 py-3 transition-all duration-300" required>
                            <option value="">Pilih Platform</option>
                            <optgroup label="🛍️ E-Commerce Indonesia">
                                <option value="Tokopedia">Tokopedia</option>
                                <option value="Shopee">Shopee</option>
                                <option value="Lazada">Lazada Indonesia</option>
                                <option value="Bukalapak">Bukalapak</option>
                                <option value="BliBli">BliBli</option>
                                <option value="JD.id">JD.id</option>
                                <option value="Zalora Indonesia">Zalora Indonesia</option>
                                <option value="Bhinneka">Bhinneka</option>
                                <option value="Elevenia">Elevenia</option>
                                <option value="Orami">Orami</option>
                            </optgroup>
                            <optgroup label="📱 Social Commerce">
                                <option value="Facebook Marketplace">Facebook Marketplace</option>
                                <option value="Instagram Shop">Instagram Shop</option>
                                <option value="TikTok Shop">TikTok Shop</option>
                                <option value="WhatsApp Business">WhatsApp Business</option>
                            </optgroup>
                            <optgroup label="🌐 Lainnya">
                                <option value="custom">Platform Lainnya...</option>
                            </optgroup>
                        </select>
                        <input type="text" id="editCustomPlatform" name="customPlatform" class="mt-3 w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-200 px-4 py-3 shadow-sm transition-all duration-300 hidden" placeholder="Masukkan nama platform...">
                        <span id="editPlatformError" class="text-red-500 text-sm mt-2 hidden flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="editPlatformErrorText"></span>
                        </span>
                    </div>

                    <!-- URL Input -->
                    <div>
                        <label for="editUrlLink" class="block text-gray-700 font-semibold mb-3 flex items-center gap-2 text-base">
                            <span class="text-2xl">🔗</span>
                            URL/Link E-Commerce
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <input type="url" name="url_link" id="editUrlLink" class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-200 pl-12 pr-4 py-3 transition-all duration-300" placeholder="https://tokopedia.com/namaToko" required>
                        </div>
                        <span id="editUrlError" class="text-red-500 text-sm mt-2 hidden flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="editUrlErrorText"></span>
                        </span>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t-2 border-gray-100">
                <button type="button" onclick="closeModal('edit')" class="px-8 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg">
                    Batal
                </button>
                <button type="submit" form="editEcommerceForm" class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function to confirm delete with SweetAlert
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Platform e-commerce yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: false,
            customClass: {
                popup: 'rounded-3xl',
                confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                cancelButton: 'rounded-xl px-6 py-3 font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Function to handle modal opening (both add and edit)
    function openModal(type) {
        const modal = document.getElementById(type + 'Modal');
        const form = document.getElementById(type + 'EcommerceForm');
        const platformError = document.getElementById(type === 'add' ? 'platformError' : 'editPlatformError');
        const urlError = document.getElementById(type === 'add' ? 'urlError' : 'editUrlError');
        const customPlatform = document.getElementById(type === 'add' ? 'customPlatform' : 'editCustomPlatform');

        if (modal) modal.classList.remove('hidden');
        if (form) form.reset();
        if (platformError) platformError.classList.add('hidden');
        if (urlError) urlError.classList.add('hidden');
        if (customPlatform) customPlatform.classList.add('hidden');
    }

    // Function to handle opening edit modal with data
    function openEditModal(id, platform, url) {
        openModal('edit');
        
        document.getElementById('editId').value = id;
        document.getElementById('editUrlLink').value = url;
        
        const editPlatformSelect = document.getElementById('editPlatform');
        const editCustomPlatform = document.getElementById('editCustomPlatform');
        
        let platformFound = false;
        for (let option of editPlatformSelect.options) {
            if (option.value === platform) {
                editPlatformSelect.value = platform;
                platformFound = true;
                break;
            }
        }
        
        if (!platformFound) {
            editPlatformSelect.value = 'custom';
            editCustomPlatform.value = platform;
            editCustomPlatform.classList.remove('hidden');
        } else {
            editCustomPlatform.classList.add('hidden');
        }
    }

    function closeModal(type) {
        if (!type) return;
        const modal = document.getElementById(type + 'Modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Handle platform selection change for both modals
        ['platform', 'editPlatform'].forEach(id => {
            const selectElement = document.getElementById(id);
            if (selectElement) {
                selectElement.addEventListener('change', function(e) {
                    const prefix = id === 'platform' ? '' : 'edit';
                    const customPlatformInput = document.getElementById(prefix + 'CustomPlatform');
                    if (customPlatformInput) {
                        if (e.target.value === 'custom') {
                            customPlatformInput.classList.remove('hidden');
                            customPlatformInput.required = true;
                        } else {
                            customPlatformInput.classList.add('hidden');
                            customPlatformInput.required = false;
                            customPlatformInput.value = '';
                        }
                    }
                });
            }
        });

        // Add click handlers for modals
        ['addModal', 'editModal'].forEach(id => {
            const modal = document.getElementById(id);
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === this) {
                        closeModal(id.replace('Modal', ''));
                    }
                });
            }
        });

        // Add ESC key handler
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                ['add', 'edit'].forEach(type => {
                    const modal = document.getElementById(type + 'Modal');
                    if (modal && !modal.classList.contains('hidden')) {
                        closeModal(type);
                    }
                });
            }
        });
    });

    function submitForm(event, type) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        
        // Reset error messages
        const prefix = type === 'add' ? '' : 'edit';
        const platformError = document.getElementById(prefix + 'PlatformError');
        const urlError = document.getElementById(prefix + 'UrlError');

        if (platformError) platformError.classList.add('hidden');
        if (urlError) urlError.classList.add('hidden');

        // Handle custom platform
        if (formData.get('platform') === 'custom') {
            const customPlatform = formData.get('customPlatform');
            if (customPlatform) {
                formData.set('platform', customPlatform);
            }
        }
        formData.delete('customPlatform');

        // Show loading state
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-3xl'
            },
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const url = type === 'add' 
            ? '{{ route('ecommerce.store') }}'
            : `{{ url('ecommerce') }}/${formData.get('id')}`;

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                console.error('Non-JSON response:', await response.text());
                throw new Error('Server returned non-JSON response. Please check the console for details.');
            }

            const data = await response.json();
            
            if (!response.ok) {
                if (response.status === 419) {
                    throw new Error('Sesi telah kedaluwarsa. Silakan muat ulang halaman.');
                }
                throw new Error(data.message || 'Terjadi kesalahan pada server.');
            }

            return data;
        })
        .then(data => {
            closeModal(type);
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message || 'Data berhasil disimpan',
                timer: 1500,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl',
                    icon: 'border-none'
                }
            }).then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Terjadi kesalahan. Silakan coba lagi.',
                showConfirmButton: true,
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        });
    }

    // Debug info for development
    window.onSubmitError = function(error) {
        console.error('Form submission error:', error);
    };
</script>
@endpush
@endsection