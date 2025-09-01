<x-filament-panels::page>
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Admin</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Selamat datang di sistem monitoring air, Admin!</p>
            </div>
            <div class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">Administrator</span>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Total Users Card --}}
        <div class="shadow-xl roup relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-blue-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between ">
                <div>
                    <p class="text-blue-600 dark:text-blue-400 text-sm font-medium uppercase tracking-wide">Total Users</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-2">
                        {{ \App\Models\User::count() }}
                    </p>
                    <p class="text-blue-700 dark:text-blue-300 text-sm mt-1 ">Pengguna sistem</p>
                </div>
                <div class="bg-blue-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        
        {{-- Total Pelanggan Aktif Card --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 dark:text-emerald-400 text-sm font-medium uppercase tracking-wide">Pelanggan Aktif</p>
                    <p class="text-3xl font-bold text-emerald-900 dark:text-emerald-100 mt-2">
                        {{ \App\Models\Pelanggan::count() }}
                    </p>
                    <p class="text-emerald-700 dark:text-emerald-300 text-sm mt-1">Total pelanggan</p>
                </div>
                <div class="bg-emerald-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>

        {{-- Total Pemakaian Air Card --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 border border-cyan-200 dark:border-cyan-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-cyan-500/25 transition-all duration-300 hover:-translate-y-1">
            @php
                $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
                $totalPemakaian = $periodeAktif ? 
                    \App\Models\Pemakaian::where('periode_id', $periodeAktif->id)->sum('total_pakai') : 0;
            @endphp
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-600 dark:text-cyan-400 text-sm font-medium uppercase tracking-wide">Pemakaian Air</p>
                    <p class="text-3xl font-bold text-cyan-900 dark:text-cyan-100 mt-2">
                        {{ number_format($totalPemakaian) }} <span class="text-lg">m³</span>
                    </p>
                    <p class="text-cyan-700 dark:text-cyan-300 text-sm mt-1">Periode aktif</p>
                </div>
                <div class="bg-cyan-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        
        {{-- Pengaduan Belum Diproses Card --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 border border-amber-200 dark:border-amber-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 dark:text-amber-400 text-sm font-medium uppercase tracking-wide">Pengaduan</p>
                    <p class="text-3xl font-bold text-amber-900 dark:text-amber-100 mt-2">
                        {{ \App\Models\Pengaduan::where('status', '!=', 'diproses')->orWhereNull('status')->count() }}
                    </p>
                    <p class="text-amber-700 dark:text-amber-300 text-sm mt-1">Belum diproses</p>
                </div>
                <div class="bg-amber-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-amber-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        
    </div>

    {{-- Additional Info Section --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                Aksi Cepat
            </h3>
            <div class="space-y-3">
                <a href="/users" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                    </svg>
                    <span class="text-dark-700 dark:text-gray-300">Kelola Users</span>
                </a>
                <a href="/pelanggans" class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                    <span class="text-dark-700 dark:text-gray-300">Kelola Pelanggan</span>
                </a>
                <a href="/pengaduans" class="flex items-center p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-dark-700 dark:text-gray-300">Lihat Pengaduan</span>
                </a>
            </div>
        </div>

        {{-- System Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Status Sistem
            </h3>
            <div class="space-y-3">
                @php
                    $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
                @endphp
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Periode Aktif</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $periodeAktif ? $periodeAktif->nama_periode : 'Tidak ada' }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Status Server</span>
                    <span class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        <span class="font-medium text-green-600 dark:text-green-400">Online</span>
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Tanggal</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        {{ date('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Main Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Users Stat --}}
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">+12% dari bulan lalu</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Total Users</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Jumlah pengguna sistem</p>
        </div>
        
        {{-- Total Pelanggan Stat --}}
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Pelanggan::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Terdaftar</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Pelanggan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total pelanggan aktif</p>
        </div>

        {{-- Total Pemakaian Stat --}}
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPemakaian) }} <span class="text-sm font-normal">m³</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Periode ini</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Pemakaian Air</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total periode aktif</p>
        </div>
        
        {{-- Pengaduan Stat --}}
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Pengaduan::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Pengaduan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Laporan dari pelanggan</p>
        </div>
        
    </div>
</x-filament-panels::page>
