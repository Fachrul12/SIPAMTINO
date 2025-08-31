<x-filament-panels::page>
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Petugas</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Monitor dan catat pemakaian air pelanggan</p>
            </div>
            <div class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-green-500 to-teal-600 text-white px-4 py-2 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">Petugas</span>
            </div>
        </div>
    </div>

    {{-- Main Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Total Users Card --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-800/20 rounded-2xl border border-blue-200 dark:border-blue-700 p-6 hover:shadow-lg hover:shadow-blue-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-blue-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ \App\Models\User::count() }}</p>
                    <p class="text-blue-700 dark:text-blue-300 text-sm font-medium">Total Users</p>
                </div>
            </div>
        </div>
        
        {{-- Total Pelanggan Aktif Card --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-green-100 dark:from-emerald-900/20 dark:to-green-800/20 rounded-2xl border border-emerald-200 dark:border-emerald-700 p-6 hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-emerald-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ \App\Models\Pelanggan::count() }}</p>
                    <p class="text-emerald-700 dark:text-emerald-300 text-sm font-medium">Pelanggan Aktif</p>
                </div>
            </div>
        </div>

        {{-- Sudah Dicatat Card --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-2xl border border-green-200 dark:border-green-700 p-6 hover:shadow-lg hover:shadow-green-500/25 transition-all duration-300 hover:-translate-y-1">
            @php
                $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
                $pelangganSudahDicatat = $periodeAktif ? 
                    \App\Models\Pemakaian::where('periode_id', $periodeAktif->id)
                        ->distinct('pelanggan_id')
                        ->count('pelanggan_id') : 0;
            @endphp
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-green-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $pelangganSudahDicatat }}</p>
                    <p class="text-green-700 dark:text-green-300 text-sm font-medium">Sudah Dicatat</p>
                </div>
            </div>
        </div>
        
        {{-- Belum Dicatat Card --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-orange-50 to-red-100 dark:from-orange-900/20 dark:to-red-800/20 rounded-2xl border border-orange-200 dark:border-orange-700 p-6 hover:shadow-lg hover:shadow-orange-500/25 transition-all duration-300 hover:-translate-y-1">
            @php
                $totalPelanggan = \App\Models\Pelanggan::count();
                $pelangganBelumDicatat = $totalPelanggan - $pelangganSudahDicatat;
            @endphp
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-orange-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-orange-900 dark:text-orange-100">{{ $pelangganBelumDicatat }}</p>
                    <p class="text-orange-700 dark:text-orange-300 text-sm font-medium">Belum Dicatat</p>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Progress Section --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Progress Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Progress Pencatatan
            </h3>
            
            @php
                $persentaseSelesai = $totalPelanggan > 0 ? round(($pelangganSudahDicatat / $totalPelanggan) * 100) : 0;
            @endphp
            
            <div class="mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pencatatan Periode Ini</span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $persentaseSelesai }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-3 rounded-full transition-all duration-500" style="width: {{ $persentaseSelesai }}%"></div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $pelangganSudahDicatat }}</p>
                    <p class="text-sm text-green-700 dark:text-green-300">Selesai</p>
                </div>
                <div class="text-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $pelangganBelumDicatat }}</p>
                    <p class="text-sm text-orange-700 dark:text-orange-300">Tersisa</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                Aksi Cepat
            </h3>
            <div class="space-y-3">
                <a href="/pemakaians/create" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">Catat Pemakaian</span>
                </a>
                <a href="/pemakaians" class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">Lihat Data Pemakaian</span>
                </a>
                <a href="/pelanggans" class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors duration-200">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">Daftar Pelanggan</span>
                </a>
            </div>
        </div>
        
    </div>

    {{-- Detailed Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Users Detailed --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Semua role</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Total Users</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Admin, Petugas, Pelanggan</p>
        </div>
        
        {{-- Pelanggan Detailed --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
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
            <h4 class="font-semibold text-gray-900 dark:text-white">Pelanggan Aktif</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total yang harus dicatat</p>
        </div>

        {{-- Progress Pencatatan --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pelangganSudahDicatat }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Selesai</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Sudah Dicatat</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pencatatan periode ini</p>
        </div>
        
        {{-- Sisa Pencatatan --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pelangganBelumDicatat }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tersisa</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Belum Dicatat</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Perlu segera dicatat</p>
        </div>
        
    </div>
</x-filament-panels::page>
