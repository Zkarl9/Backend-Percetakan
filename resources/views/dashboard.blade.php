@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <!-- Welcome Section -->
    <div class="mx-4 sm:mx-6 lg:mx-8 mb-8">
        <div class="bg-gradient-to-r from-pink-500 via-pink-600 to-pink-500 shadow-xl rounded-2xl p-8 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative flex items-center justify-between">
                <div class="flex-1">
                    <h2 class="text-3xl font-bold text-white mb-3 flex items-center gap-3">
                        Selamat Datang Kembali, {{ auth()->user()->name }}! 
                        <span class="text-4xl">👋</span>
                    </h2>
                    <p class="text-pink-50 text-lg">
                        Anda masuk sebagai 
                        <span class="font-semibold bg-white/20 px-3 py-1 rounded-full inline-block">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </p>
                </div>
                <div class="hidden lg:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-5 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mx-4 sm:mx-6 lg:mx-8 mb-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Products Card -->
            <div class="bg-gradient-to-br from-white to-emerald-50/30 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-emerald-200/50 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-emerald-700 mb-1">Total Produk</h3>
                                <p class="text-3xl font-bold text-emerald-600">
                                    {{ number_format($totalProduk) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'superadmin')
            <!-- Total Admin Card -->
            <div class="bg-gradient-to-br from-white to-violet-50/30 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-violet-200/50 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div class="p-4 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-violet-700 mb-1">Total Admin</h3>
                                <p class="text-3xl font-bold text-violet-600">
                                    {{ number_format($totalAdmin) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Last Login Card -->
            <div class="bg-gradient-to-br from-white to-blue-50/30 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-blue-200/50 group">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-blue-700 mb-1">Login Terakhir</h3>
                        <p class="text-sm text-gray-700 font-medium">
                            @if(auth()->user()->last_login)
                                {{ auth()->user()->last_login->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            @else
                                Belum pernah login
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            @if(auth()->user()->last_login)
                                {{ str_replace(['ago', 'from now', 'seconds', 'second', 'minutes', 'minute', 'hours', 'hour', 'days', 'day', 'weeks', 'week', 'months', 'month', 'years', 'year'], ['yang lalu', 'dari sekarang', 'detik', 'detik', 'menit', 'menit', 'jam', 'jam', 'hari', 'hari', 'minggu', 'minggu', 'bulan', 'bulan', 'tahun', 'tahun'], auth()->user()->last_login->diffForHumans()) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="bg-gradient-to-br from-white to-{{ auth()->user()->isActive() ? 'green' : 'red' }}-50/30 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-{{ auth()->user()->isActive() ? 'green' : 'red' }}-200/50 group">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-xl 
                        @if(auth()->user()->isActive())
                            bg-gradient-to-br from-green-500 to-green-600
                        @else
                            bg-gradient-to-br from-red-500 to-red-600
                        @endif
                        text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold 
                            @if(auth()->user()->isActive())
                                text-green-700
                            @else
                                text-red-700
                            @endif
                            mb-1">Status Akun</h3>
                        <p class="text-lg font-bold">
                            @if(auth()->user()->isActive())
                                <span class="text-green-600">Aktif</span>
                            @else
                                <span class="text-red-600">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Access Level Card -->
            <div class="bg-gradient-to-br from-white to-purple-50/30 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-purple-200/50 group">
                <div class="flex items-center gap-4">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-purple-700 mb-1">Access Level</h3>
                        <p class="text-sm font-semibold text-purple-600">
                            @if(auth()->user()->isSuperAdmin())
                                Full System Access
                            @else
                                Limited Management
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="mx-4 sm:mx-6 lg:mx-8 mb-8">
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200/50 overflow-hidden">
            <div class="p-6 border-b-2 border-gray-200 bg-gradient-to-r from-pink-50 via-white to-pink-50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-pink-500 rounded-lg shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <div class="max-h-[450px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aktivitas</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($activities as $activity)
                            <tr class="hover:bg-pink-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $activity->user->name }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                    {{ $activity->user->role === 'superadmin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                                                    {{ $activity->user->role === 'superadmin' ? 'Super Admin' : 'Admin' }}
                                                </span>
                                                @if($activity->user->id === auth()->id())
                                                    <span class="text-xs text-pink-600 font-medium">(Anda)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1.5 inline-flex items-center gap-1.5 text-xs font-semibold rounded-full 
                                        @if($activity->activity_type === 'create') bg-green-100 text-green-700 border border-green-200
                                        @elseif($activity->activity_type === 'update') bg-yellow-100 text-yellow-700 border border-yellow-200
                                        @else bg-red-100 text-red-700 border border-red-200 @endif shadow-sm">
                                        @if($activity->activity_type === 'create')
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Tambah
                                        @elseif($activity->activity_type === 'update')
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                            Ubah
                                        @else
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Hapus
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-md">
                                        {{ $activity->description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        {{ str_replace(['ago', 'from now', 'seconds', 'second', 'minutes', 'minute', 'hours', 'hour', 'days', 'day', 'weeks', 'week', 'months', 'month', 'years', 'year'], 
                                            ['yang lalu', 'dari sekarang', 'detik', 'detik', 'menit', 'menit', 'jam', 'jam', 'hari', 'hari', 'minggu', 'minggu', 'bulan', 'bulan', 'tahun', 'tahun'], 
                                            $activity->created_at->diffForHumans()) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $activity->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada aktivitas</p>
                                        <p class="text-gray-400 text-sm mt-1">Aktivitas akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($activities->hasPages())
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t-2 border-gray-200">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>

</div>
@endsection