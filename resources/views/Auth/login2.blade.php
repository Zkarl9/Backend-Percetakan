@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-gray-800 rounded-lg shadow-xl p-8">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-600 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Management Portal</h1>
                <p class="text-gray-400">Sign in to access admin dashboard</p>
            </div>
        </div>

        <form class="space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Admin Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" required 
                        class="appearance-none block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="admin@company.com">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" required 
                        class="appearance-none block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 bg-gray-700 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-300">
                    Remember this device
                </label>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Access Dashboard
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gray-800 text-gray-400">Access Levels</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-3">
                <div class="flex items-center text-sm text-gray-400">
                    <span class="w-3 h-3 bg-indigo-500 rounded-full mr-2"></span>
                    <span class="font-medium text-gray-300">Super Admin</span>
                    <span class="ml-1">- Full system access</span>
                </div>
                <div class="flex items-center text-sm text-gray-400">
                    <span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                    <span class="font-medium text-gray-300">Admin</span>
                    <span class="ml-1">- Limited management access</span>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-xs text-gray-400">Secured with 256-bit SSL encryption</p>
        </div>
    </div>
</div>
@endsection