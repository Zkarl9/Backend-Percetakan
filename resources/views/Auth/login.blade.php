@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <!-- Animated pattern background -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);">
        </div>
    </div>

    <!-- Grid pattern overlay -->
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

    <!-- Geometric shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-cyan-500/5 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
        <div class="absolute top-1/2 right-1/4 w-32 h-32 border border-cyan-500/10 rotate-45 animate-spin-slow"></div>
        <div class="absolute bottom-1/3 left-1/4 w-24 h-24 border border-blue-500/10 animate-spin-slow animation-delay-1000"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-6 py-8">
        <!-- Main card -->
        <div class="relative">
            <!-- Glow effect -->
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-600 to-blue-600 rounded-3xl blur-xl opacity-20"></div>
            
            <!-- Card content -->
            <div class="relative bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-700/50 p-8">
                
                <!-- Admin Badge -->
                <div class="flex justify-center mb-6">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur-md group-hover:blur-lg transition-all duration-300 opacity-75"></div>
                        <div class="relative px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 rounded-2xl border border-cyan-400/30">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-white font-bold text-sm tracking-wider">ADMIN ACCESS</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl flex items-center justify-center shadow-2xl border border-slate-600 transform group-hover:scale-105 transition-all duration-300">
                            <svg class="w-10 h-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Management Portal
                    </h2>
                    <p class="text-slate-400 text-sm">Sign in to access admin dashboard</p>
                </div>

                <!-- Form -->
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Admin Email
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-900/70 border-2 border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300" 
                                placeholder="admin@company.com">
                        </div>
                        @error('email')
                            <div class="flex items-start space-x-2 bg-red-500/10 border border-red-500/30 backdrop-blur-sm rounded-lg px-4 py-3">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-red-400 text-sm font-medium">Authentication Error</p>
                                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <!-- Password field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-900/70 border-2 border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300" 
                                placeholder="••••••••••">
                        </div>
                        @error('password')
                            <div class="flex items-start space-x-2 bg-red-500/10 border border-red-500/30 backdrop-blur-sm rounded-lg px-4 py-3">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-red-400 text-sm font-medium">Authentication Error</p>
                                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                class="h-4 w-4 rounded border-slate-600 bg-slate-900/50 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0 focus:ring-offset-slate-800 cursor-pointer transition-all duration-200">
                            <label for="remember" class="ml-3 block text-sm text-slate-300 cursor-pointer select-none">
                                Remember this device
                            </label>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 p-[2px] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-cyan-500/50 focus:scale-[1.02]">
                            <div class="relative rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-4 transition-all duration-300 group-hover:from-cyan-500 group-hover:to-blue-500">
                                <span class="relative flex items-center justify-center text-base font-bold text-white tracking-wide">
                                    <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Access Dashboard
                                </span>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-700"></div>
                    </div>
                </div>

                <!-- Security info -->
                <div class="space-y-3">
                    <div class="flex items-center justify-center text-slate-500 text-xs">
                        <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Secured with 256-bit SSL encryption
                    </div>
                    
                    <!-- Access levels info -->
                    <div class="bg-slate-900/50 border border-slate-700 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-xs text-slate-400">
                                <p class="font-semibold text-slate-300 mb-1">Access Levels:</p>
                                <ul class="space-y-1">
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-cyan-400 rounded-full mr-2"></span>
                                        <span><strong class="text-cyan-400">Super Admin</strong> - Full system access</span>
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                        <span><strong class="text-blue-400">Admin</strong> - Limited management access</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center space-y-2">
            <p class="text-slate-500 text-xs">
                For security reasons, all login attempts are monitored and logged
            </p>
            <p class="text-slate-600 text-xs">
                © 2024 PrintPro Management System. All rights reserved.
            </p>
        </div>
    </div>
</div>

<style>
    .bg-grid-pattern {
        background-image: 
            linear-gradient(rgba(100, 200, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(100, 200, 255, 0.03) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin-slow {
        animation: spin-slow 25s linear infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 0.05;
        }
        50% {
            opacity: 0.1;
        }
    }
    
    .animate-pulse {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Custom autofill styling */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: white;
        -webkit-box-shadow: 0 0 0px 1000px rgba(15, 23, 42, 0.7) inset;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>
@endsection