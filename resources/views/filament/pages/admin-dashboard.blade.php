<x-filament-panels::page>
    @php
        $stats = $this->getSystemStats();
        $selectedPeriode = request('periode_id');
        $monthlyStats = $this->getMonthlyStats($selectedPeriode);
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

        {{-- Calon Pelanggan Pending --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 border border-indigo-200 dark:border-indigo-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-indigo-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-600 dark:text-indigo-400 text-sm font-medium uppercase tracking-wide">Calon Pelanggan Pending</p>
                    <p class="text-3xl font-bold text-indigo-900 dark:text-indigo-100 mt-2">
                        {{ $stats['calon_pelanggan_pending'] }}
                    </p>
                    <p class="text-indigo-700 dark:text-indigo-300 text-sm mt-1">Menunggu verifikasi</p>
                </div>
                <div class="bg-indigo-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
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
    
</x-filament-panels::page>
