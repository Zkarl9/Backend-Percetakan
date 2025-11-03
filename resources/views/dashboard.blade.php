@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 shadow-lg rounded-lg mx-6 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-indigo-100">
                    You are logged in as <span class="font-semibold">{{ auth()->user()->role }}</span>
                </p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/10 rounded-lg p-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3 px-4">
        <!-- Last Login Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Last Login</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(auth()->user()->last_login)
                            {{ auth()->user()->last_login->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            ({{ auth()->user()->last_login->diffForHumans() }})
                        @else
                            Never logged in before
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Account Status Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full 
                    @if(auth()->user()->isActive())
                        bg-green-100 text-green-600
                    @else
                        bg-red-100 text-red-600
                    @endif
                ">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Account Status</h3>
                    <p class="mt-1 text-sm">
                        @if(auth()->user()->isActive())
                            <span class="text-green-600 font-medium">Active & Ready</span>
                        @else
                            <span class="text-red-600 font-medium">Account Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Access Level Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Access Level</h3>
                    <p class="mt-1 text-sm text-purple-600">
                        @if(auth()->user()->isSuperAdmin())
                            Full System Access
                        @else
                            Limited Management Access
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 px-4">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Quick Actions</h3>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Add New Admin</span>
                </a>
                <a href="{{ route('admin.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Manage Admins</span>
                </a>
                @endif

                <a href="{{ route('password.change') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Change Password</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                        <div class="p-2 rounded-full bg-red-100 text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection