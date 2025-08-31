<x-filament-panels::page>
    @php
        $user = auth()->user();
        $pelanggan = $user->pelanggan;
        $totalPemakaianPelanggan = $pelanggan ? 
            \App\Models\Pemakaian::where('pelanggan_id', $pelanggan->id)->sum('total_pakai') : 0;
            
        $totalTagihanBelumBayar = $pelanggan ? 
            \App\Models\Pembayaran::whereHas('pemakaian', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id);
            })->where('status', 'belum_lunas')->count() : 0;
        
        $totalTagihanLunas = $pelanggan ? 
            \App\Models\Pembayaran::whereHas('pemakaian', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id);
            })->where('status', 'lunas')->count() : 0;
    @endphp

    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Pelanggan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Monitor pemakaian air dan tagihan Anda</p>
            </div>
            <div class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white px-4 py-2 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">Pelanggan</span>
            </div>
        </div>
    </div>

    {{-- Personal Stats Grid --}}
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
        
        {{-- Pemakaian Air Pelanggan --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-cyan-50 to-blue-100 dark:from-cyan-900/20 dark:to-blue-800/20 rounded-2xl border border-cyan-200 dark:border-cyan-700 p-6 hover:shadow-lg hover:shadow-cyan-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-cyan-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-cyan-900 dark:text-cyan-100">{{ number_format($totalPemakaianPelanggan) }} <span class="text-lg font-normal">m³</span></p>
                    <p class="text-cyan-700 dark:text-cyan-300 text-sm font-medium">Pemakaian Air</p>
                </div>
            </div>
        </div>

        {{-- Total Tagihan Belum Dibayar --}}
        <div class="group relative overflow-hidden bg-gradient-to-br {{ $totalTagihanBelumBayar > 0 ? 'from-red-50 to-pink-100 dark:from-red-900/20 dark:to-pink-800/20 border-red-200 dark:border-red-700' : 'from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 border-green-200 dark:border-green-700' }} rounded-2xl border p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="{{ $totalTagihanBelumBayar > 0 ? 'bg-red-500' : 'bg-green-500' }} rounded-lg p-2 w-fit mb-3">
                        @if($totalTagihanBelumBayar > 0)
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <p class="text-2xl font-bold {{ $totalTagihanBelumBayar > 0 ? 'text-red-900 dark:text-red-100' : 'text-green-900 dark:text-green-100' }}">{{ $totalTagihanBelumBayar }}</p>
                    <p class="{{ $totalTagihanBelumBayar > 0 ? 'text-red-700 dark:text-red-300' : 'text-green-700 dark:text-green-300' }} text-sm font-medium">Tagihan Belum Bayar</p>
                </div>
            </div>
        </div>
        
        {{-- Total Pengaduan --}}
        <div class="group relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-2xl border border-amber-200 dark:border-amber-700 p-6 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-amber-500 rounded-lg p-2 w-fit mb-3">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ \App\Models\Pengaduan::where('user_id', auth()->id())->count() }}</p>
                    <p class="text-amber-700 dark:text-amber-300 text-sm font-medium">Total Pengaduan</p>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Personal Info Section --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Usage Summary --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                Ringkasan Pemakaian
            </h3>
            
            @php
                $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
                $pemakaianBulanIni = $pelanggan && $periodeAktif ? 
                    \App\Models\Pemakaian::where('pelanggan_id', $pelanggan->id)
                        ->where('periode_id', $periodeAktif->id)
                        ->first() : null;
            @endphp
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Pemakaian Bulan Ini</span>
                    <span class="font-bold text-blue-600 dark:text-blue-400">
                        {{ $pemakaianBulanIni ? $pemakaianBulanIni->total_pakai . ' m³' : 'Belum dicatat' }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Total Keseluruhan</span>
                    <span class="font-bold text-green-600 dark:text-green-400">
                        {{ number_format($totalPemakaianPelanggan) }} m³
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Rata-rata per Bulan</span>
                    @php
                        $jumlahBulan = $pelanggan ? \App\Models\Pemakaian::where('pelanggan_id', $pelanggan->id)->count() : 0;
                        $rataRata = $jumlahBulan > 0 ? round($totalPemakaianPelanggan / $jumlahBulan, 1) : 0;
                    @endphp
                    <span class="font-bold text-purple-600 dark:text-purple-400">
                        {{ $rataRata }} m³
                    </span>
                </div>
            </div>
        </div>

        {{-- Billing Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                </svg>
                Info Tagihan
            </h3>
            
            <div class="space-y-4">
                @php
                    $tagihanTertua = $pelanggan ? 
                        \App\Models\Pembayaran::whereHas('pemakaian', function ($query) use ($pelanggan) {
                            $query->where('pelanggan_id', $pelanggan->id);
                        })
                        ->where('status', 'belum_lunas')
                        ->orderBy('created_at', 'asc')
                        ->first() : null;
                    $jumlahTagihanTertua = $tagihanTertua ? 'Rp ' . number_format($tagihanTertua->jumlah_bayar, 0, ',', '.') : 'Tidak Ada';
                @endphp
                <div class="flex items-center justify-between p-3 {{ $tagihanTertua ? 'bg-red-50 dark:bg-red-900/20' : 'bg-green-50 dark:bg-green-900/20' }} rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Tagihan Tertua</span>
                    <span class="font-bold {{ $tagihanTertua ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                        {{ $jumlahTagihanTertua }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Tagihan Belum Bayar</span>
                    <span class="font-bold text-orange-600 dark:text-orange-400">
                        {{ $totalTagihanBelumBayar }} tagihan
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Tagihan Lunas</span>
                    <span class="font-bold text-green-600 dark:text-green-400">
                        {{ $totalTagihanLunas }} tagihan
                    </span>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Detailed Personal Stats --}}
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sistem</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Total Users</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pengguna terdaftar</p>
        </div>
        
        {{-- Pemakaian Detailed --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPemakaianPelanggan) }} <span class="text-sm font-normal">m³</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sejak terdaftar</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Pemakaian Air</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total konsumsi Anda</p>
        </div>

        {{-- Tagihan Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r {{ $totalTagihanBelumBayar > 0 ? 'from-red-500 to-red-600' : 'from-green-500 to-green-600' }} rounded-full p-3">
                    @if($totalTagihanBelumBayar > 0)
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalTagihanBelumBayar }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum bayar</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Status Tagihan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $totalTagihanBelumBayar > 0 ? 'Ada tagihan yang perlu dibayar' : 'Semua tagihan lunas' }}</p>
        </div>
        
        {{-- Pengaduan Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Pengaduan::where('user_id', auth()->id())->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total dibuat</p>
                </div>
            </div>
            <h4 class="font-semibold text-gray-900 dark:text-white">Pengaduan</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400">Riwayat pengaduan Anda</p>
        </div>
        
    </div>

    {{-- Status Pemakaian dan Pembayaran --}}
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Status Pemakaian dan Pembayaran
            </h3>
            
            @php
                if ($pelanggan) {
                    // Ambil semua pemakaian pelanggan dengan pembayaran
                    $pemakaianWithPembayaran = \App\Models\Pemakaian::where('pelanggan_id', $pelanggan->id)
                        ->with(['pembayaran', 'periode'])
                        ->orderBy('created_at', 'desc')
                        ->take(5) // Tampilkan 5 terbaru
                        ->get();
                } else {
                    $pemakaianWithPembayaran = collect();
                }
            @endphp
            
            @if($pemakaianWithPembayaran->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Periode</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Pemakaian</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Tagihan</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Status Bayar</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemakaianWithPembayaran as $pemakaian)
                                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $pemakaian->periode->nama_periode ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-gray-700 dark:text-gray-300">{{ number_format($pemakaian->total_pakai) }} m³</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($pemakaian->pembayaran)
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                Rp {{ number_format($pemakaian->pembayaran->jumlah_bayar, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">Belum ada tagihan</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($pemakaian->pembayaran)
                                            @if($pemakaian->pembayaran->status === 'lunas')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                                                </svg>
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($pemakaian->pembayaran && $pemakaian->pembayaran->tanggal_bayar)
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($pemakaian->pembayaran->tanggal_bayar)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Belum ada data pemakaian</p>
                </div>
            @endif
            </div>
        </div>
    
    {{-- Quick Actions for Customer --}}
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="/pengaduans/create" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/40 dark:hover:to-indigo-900/40 transition-all duration-200 group">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">Buat Pengaduan</span>
                </a>
                <a href="/pengaduans" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/40 dark:hover:to-emerald-900/40 transition-all duration-200 group">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">Lihat Pengaduan</span>
                </a>
                <a href="#" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-lg hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-900/40 dark:hover:to-pink-900/40 transition-all duration-200 group">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-3 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">Riwayat Pemakaian</span>
                </a>
            </div>
        </div>
        
    </div>
</x-filament-panels::page>
