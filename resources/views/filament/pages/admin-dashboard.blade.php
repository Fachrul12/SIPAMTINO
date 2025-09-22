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

    <div class="mt-8">
        <div class="w-full">
            @livewire(\App\Filament\Resources\WidgetResource\Widgets\TurbidityChart::class)
        </div>
    </div>
    
    {{-- Financial & Progress Section --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
        
        {{-- Financial Overview --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                </svg>
                Keuangan
            </h3>
        
            <!-- wrapper untuk posisi center -->
            <div class="flex justify-center">
                <div class="w-48 h-48"> {{-- atur ukuran pie chart --}}
                    <canvas id="keuanganPieChart"></canvas>
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
        
            <div class="flex flex-col items-center">
                <!-- Radial Progress -->
                <div class="relative w-40 h-40">
                    <canvas id="progressRadial"></canvas>
                    <!-- Persentase di tengah -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['progress_pencatatan'] }}%
                        </span>
                    </div>
                </div>
        
                <!-- Keterangan -->
                <div class="mt-4 space-y-2 text-center">
                    <div class="flex justify-between gap-8">
                        <span class="text-green-600 dark:text-green-400 font-semibold">Sudah: {{ $stats['pelanggan_sudah_dicatat'] }}</span>
                        <span class="text-red-600 dark:text-red-400 font-semibold">Belum: {{ $stats['pelanggan_belum_dicatat'] }}</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">
                        Total: {{ $stats['total_pelanggan'] }}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mt-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Grafik Pemakaian Air per Periode
            </h3>
                      
            <form method="GET" class="mb-4">
                <label for="tahun" class="text-gray-700 dark:text-gray-300">Pilih Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" 
                        class="ml-2 p-2 rounded-lg border dark:bg-gray-800 dark:text-gray-300">
                    @foreach ($monthlyStats['availableYears'] as $year)
                        <option value="{{ $year }}" {{ $year == $monthlyStats['selectedYear'] ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
            
            
        </div>
    
        <div class="relative" style="height:350px;">
            <canvas id="monthlyChart" class="w-full h-80"></canvas>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

   
   
   
   <script>
        const ctxRadial = document.getElementById('progressRadial').getContext('2d');
    new Chart(ctxRadial, {
        type: 'doughnut',
        data: {
            labels: ['Sudah Dicatat', 'Belum Dicatat'],
            datasets: [{
                data: [
                    {{ $stats['pelanggan_sudah_dicatat'] ?? 0 }},
                    {{ $stats['pelanggan_belum_dicatat'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(34,197,94,0.8)',  // hijau
                    'rgba(229,62,62,0.3)'   // merah muda transparan (biar kayak background)
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%', // bikin jadi radial progress
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        }
    });
    

        const ctxKeuangan = document.getElementById('keuanganPieChart').getContext('2d');
    new Chart(ctxKeuangan, {
        type: 'pie',
        data: {
            labels: [
                'Total Pendapatan',
                'Pendapatan Bulan Ini',
                'Tagihan Belum Bayar'
            ],
            datasets: [{
                data: [
                    {{ $stats['total_pendapatan'] ?? 0 }},
                    {{ $stats['pendapatan_bulan_ini'] ?? 0 }},
                    {{ $stats['tagihan_belum_bayar'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(34,197,94,0.7)',  // green
                    'rgba(59,130,246,0.7)', // blue
                    'rgba(249,115,22,0.7)'  // orange
                ],
                borderColor: [
                    'rgba(34,197,94,1)',
                    'rgba(59,130,246,1)',
                    'rgba(249,115,22,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            if (context.dataIndex === 2) {
                                return value + ' tagihan';
                            }
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });


        const ctx = document.getElementById('monthlyChart').getContext('2d');
    
        function getColors() {
            // Jika HTML punya class 'dark', berarti dark mode aktif
            const isDarkMode = document.documentElement.classList.contains('dark');
    
            return {
                text: isDarkMode ? '#fff' : '#000', // teks label
                grid: isDarkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)' // garis grid
            };
        }
    
        let colors = getColors();
    
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($monthlyStats['months']),
                datasets: [{
                    label: 'Pemakaian Air (m³)',
                    data: @json($monthlyStats['pemakaian_data']),
                    backgroundColor: '#06b6d4',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true
                    },
                    legend: {
                        labels: {
                            color: colors.text,
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Periode (Bulan)',
                            color: colors.text,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            color: colors.text,
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            color: colors.grid
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Pemakaian (m³)',
                            color: colors.text,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            color: colors.text,
                            stepSize: 25,
                            callback: function(value) {
                                return value + ' m³';
                            }
                        },
                        grid: {
                            color: colors.grid
                        }
                    }
                }
            }
        });

    // === Grafik Pie (Pengaduan) ===
    const pengaduanCtx = document.getElementById('pengaduanChart').getContext('2d');
    new Chart(pengaduanCtx, {
        type: 'pie',
        data: {
            labels: ['Belum Diproses', 'Selesai', 'Bulan Ini'],
            datasets: [{
                data: [
                    {{ $stats['pengaduan_belum_diproses'] }},
                    {{ $stats['pengaduan_selesai'] }},
                    {{ $stats['pengaduan_bulan_ini'] }}
                ],
                backgroundColor: [
                    '#ef4444', // merah
                    '#10b981', // hijau
                    '#3b82f6', // biru
                ],
                borderWidth: 1,
                borderColor: '#fff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // legend kita sembunyikan karena sudah ditampilkan manual
                }
            }
        }
    });

    const observer = new MutationObserver(() => {
        colors = getColors();
        chart.options.plugins.legend.labels.color = colors.text;
        chart.options.scales.x.title.color = colors.text;
        chart.options.scales.x.ticks.color = colors.text;
        chart.options.scales.x.grid.color = colors.grid;
        chart.options.scales.y.title.color = colors.text;
        chart.options.scales.y.ticks.color = colors.text;
        chart.options.scales.y.grid.color = colors.grid;
        chart.update();
    });

    // Observe perubahan class pada <html>
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
</script>
    
</x-filament-panels::page>
