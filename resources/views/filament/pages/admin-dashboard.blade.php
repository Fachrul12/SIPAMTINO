<x-filament::page>
    @php
        $stats = $this->getSystemStats();
    @endphp

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Pelanggan Aktif --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 dark:text-emerald-400 text-sm font-medium uppercase tracking-wide">Pelanggan Aktif</p>
                    <p class="text-3xl font-bold text-emerald-900 dark:text-emerald-100 mt-2">
                        {{ $stats['pelanggan_aktif'] }}
                    </p>
                    <p class="text-emerald-700 dark:text-emerald-300 text-sm mt-1">Total pelanggan</p>
                </div>
                <div class="bg-emerald-100 dark:bg-emerald-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <x-heroicon-o-user-group class="w-8 h-8 text-emerald-600 dark:text-white"/>
                </div>
            </div>
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
                <div class="bg-indigo-100 dark:bg-indigo-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <x-heroicon-o-clock class="w-8 h-8 text-indigo-600 dark:text-white"/>
                </div>
            </div>
        </div>

        {{-- Pemakaian Air --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 border border-cyan-200 dark:border-cyan-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-cyan-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-600 dark:text-cyan-400 text-sm font-medium uppercase tracking-wide">Pemakaian Air</p>
                    <p class="text-3xl font-bold text-cyan-900 dark:text-cyan-100 mt-2">
                        {{ number_format($stats['total_pemakaian_bulan_ini']) }} <span class="text-lg">m³</span>
                    </p>
                    <p class="text-cyan-700 dark:text-cyan-300 text-sm mt-1">Periode aktif</p>
                </div>
                <div class="bg-cyan-100 dark:bg-cyan-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <x-heroicon-o-cloud class="w-8 h-8 text-cyan-600 dark:text-white"/>
                </div>
            </div>
        </div>

        {{-- Pengaduan Belum Diproses --}}
        <div class="shadow-xl group relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 border border-amber-200 dark:border-amber-700 rounded-2xl p-6 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 dark:text-amber-400 text-sm font-medium uppercase tracking-wide">Pengaduan</p>
                    <p class="text-3xl font-bold text-amber-900 dark:text-amber-100 mt-2">
                        {{ $stats['pengaduan_belum_diproses'] }}
                    </p>
                    <p class="text-amber-700 dark:text-amber-300 text-sm mt-1">Belum diproses</p>
                </div>
                <div class="bg-amber-100 dark:bg-amber-500 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                    <x-heroicon-o-exclamation-circle class="w-8 h-8 text-amber-600 dark:text-white"/>
                </div>
            </div>
        </div>

    </div>      

</x-filament::page>
