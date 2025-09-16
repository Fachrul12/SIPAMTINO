<x-filament-panels::page>
    @php
        $stats = $this->getSystemStats();
        $monthlyStats = $this->getMonthlyStats();
    @endphp
    
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Admin</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Overview sistem SIPAMTINO - {{ $stats['tanggal_hari_ini'] }}</p>
            </div>
            <div class="flex flex-col items-end space-y-2">
                <div class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Administrator</span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Periode Aktif: <span class="font-semibold">{{ $stats['periode_aktif'] }}</span>
                </div>
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
                        {{ \App\Models\Pengaduan::where('status', '!=', 'Selesai')->orWhereNull('status')->count() }}
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

    {{-- Detailed Analytics Section --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- User Statistics by Role --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                Statistik Pengguna
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Administrator</span>
                    </div>
                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $stats['admin_count'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Petugas</span>
                    </div>
                    <span class="font-bold text-green-600 dark:text-green-400">{{ $stats['petugas_count'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Pelanggan</span>
                    </div>
                    <span class="font-bold text-purple-600 dark:text-purple-400">{{ $stats['pelanggan_count'] }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</span>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengaduan Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                </svg>
                Status Pengaduan
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Belum Diproses</span>
                    </div>
                    <span class="font-bold text-red-600 dark:text-red-400">{{ $stats['pengaduan_belum_diproses'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Selesai</span>
                    </div>
                    <span class="font-bold text-green-600 dark:text-green-400">{{ $stats['pengaduan_selesai'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Bulan Ini</span>
                    </div>
                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $stats['pengaduan_bulan_ini'] }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengaduan</span>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_pengaduan'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Financial & Progress Section --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Financial Overview --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                </svg>
                Keuangan
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Total Pendapatan</span>
                    </div>
                    <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Pendapatan Bulan Ini</span>
                    </div>
                    <span class="font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Tagihan Belum Bayar</span>
                    </div>
                    <span class="font-bold text-orange-600 dark:text-orange-400">{{ $stats['tagihan_belum_bayar'] }} tagihan</span>
                </div>
            </div>
        </div>

        {{-- Progress Pencatatan --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Progress Pencatatan Periode {{ $stats['periode_aktif'] }}
            </h3>
            
            {{-- Progress Bar --}}
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $stats['progress_pencatatan'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500" style="width: {{ $stats['progress_pencatatan'] }}%"></div>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Sudah Dicatat</span>
                    </div>
                    <span class="font-bold text-green-600 dark:text-green-400">{{ $stats['pelanggan_sudah_dicatat'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 dark:text-gray-300">Belum Dicatat</span>
                    </div>
                    <span class="font-bold text-red-600 dark:text-red-400">{{ $stats['pelanggan_belum_dicatat'] }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pelanggan</span>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_pelanggan'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    {{-- System Status --}}
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                </svg>
                Status Sistem SIPAMTINO
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mx-auto mb-2 animate-pulse"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Server Online</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">100% Uptime</p>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mx-auto mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Database</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Optimal</p>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mx-auto mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Periode Aktif</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['periode_aktif'] }}</p>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-3 h-3 bg-indigo-500 rounded-full mx-auto mb-2"></div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Last Update</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['tanggal_hari_ini'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
