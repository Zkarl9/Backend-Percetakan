@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .animate-slide-down {
        animation: slideDown 0.5s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-modern {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    .input-field {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .input-field:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-field.error {
        border-color: #ef4444;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        transition: color 0.3s ease;
    }

    .input-group:focus-within .input-icon {
        color: #667eea;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #374151;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .strength-bar {
        height: 4px;
        border-radius: 2px;
        background: #e5e7eb;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak { width: 33%; background: #ef4444; }
    .strength-medium { width: 66%; background: #f59e0b; }
    .strength-strong { width: 100%; background: #10b981; }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.5s ease-out;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
</style>

<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-4 text-3xl">
                🔐
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ubah Password</h1>
            <p class="text-gray-600">Perbarui password untuk keamanan akun Anda</p>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                <span class="text-2xl">✓</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <span class="text-2xl">✕</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form Card -->
        <div class="card-modern animate-slide-down">
            <form action="{{ route('password.change') }}" method="POST" class="p-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="input-group relative">
                            <div class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="current_password" required
                                class="input-field @error('current_password') error @enderror"
                                placeholder="Masukkan password saat ini">
                        </div>
                        @error('current_password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="input-group relative">
                            <div class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="input-field @error('password') error @enderror"
                                placeholder="Minimal 8 karakter"
                                oninput="checkStrength(this.value)">
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthBar"></div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500" id="strengthText"></p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="input-group relative">
                            <div class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" required
                                class="input-field"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('dashboard') }}" class="flex-1 btn-secondary text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-6 bg-blue-50 rounded-xl p-6 border border-blue-100">
            <p class="text-sm font-semibold text-blue-900 mb-3">Tips Password Aman:</p>
            <ul class="text-sm text-blue-800 space-y-2">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 mt-0.5">•</span>
                    <span>Minimal 8 karakter dengan kombinasi huruf, angka & simbol</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 mt-0.5">•</span>
                    <span>Hindari informasi pribadi yang mudah ditebak</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 mt-0.5">•</span>
                    <span>Gunakan password yang berbeda untuk setiap akun</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
function checkStrength(password) {
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    
    bar.className = 'strength-fill';
    
    if (!password) {
        text.textContent = '';
        return;
    }
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    if (strength <= 2) {
        bar.classList.add('strength-weak');
        text.textContent = 'Lemah';
        text.className = 'mt-1.5 text-xs text-red-600 font-medium';
    } else if (strength <= 4) {
        bar.classList.add('strength-medium');
        text.textContent = 'Sedang';
        text.className = 'mt-1.5 text-xs text-yellow-600 font-medium';
    } else {
        bar.classList.add('strength-strong');
        text.textContent = 'Kuat';
        text.className = 'mt-1.5 text-xs text-green-600 font-medium';
    }
}
</script>

@endsection