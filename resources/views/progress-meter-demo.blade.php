<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Progress Meter - SIPAMTINO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/progress-meter.css') }}">
</head>
<body class="bg-gray-100 dark:bg-gray-900 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
            🚿 Demo Progress Meter Dashboard Petugas
        </h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Progress Meter 25% (Perlu Perhatian) --}}
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">25% - Perlu Perhatian 🔴</h2>
                <x-progress-meter 
                    id="demo-progress-25"
                    title="Pencatatan Periode Januari"
                    :completed="25"
                    :total="100"
                    description="Status pencatatan masih rendah"
                    period="Januari 2024"
                />
            </div>

            {{-- Progress Meter 60% (Sedang Progress) --}}
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">60% - Sedang Progress 🟡</h2>
                <x-progress-meter 
                    id="demo-progress-60"
                    title="Pencatatan Periode Februari"
                    :completed="60"
                    :total="100"
                    description="Pencatatan berjalan dengan baik"
                    period="Februari 2024"
                />
            </div>

            {{-- Progress Meter 85% (Hampir Selesai) --}}
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">85% - Hampir Selesai 🔵</h2>
                <x-progress-meter 
                    id="demo-progress-85"
                    title="Pencatatan Periode Maret"
                    :completed="85"
                    :total="100"
                    description="Pencatatan hampir selesai"
                    period="Maret 2024"
                />
            </div>

            {{-- Progress Meter 100% (Selesai) --}}
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">100% - Selesai ✅</h2>
                <x-progress-meter 
                    id="demo-progress-100"
                    title="Pencatatan Periode April"
                    :completed="100"
                    :total="100"
                    description="Pencatatan telah selesai sempurna"
                    period="April 2024"
                />
            </div>
            
        </div>

        {{-- Demo dengan Data Real --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">
                📊 Progress Meter dengan Data Simulasi Real
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- Progress Meter dengan Data Besar --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Data Pelanggan Besar</h3>
                    <x-progress-meter 
                        id="demo-progress-large"
                        title="Pencatatan Area Perumahan"
                        :completed="847"
                        :total="1250"
                        description="Pencatatan di area perumahan besar"
                        period="Mei 2024"
                    />
                </div>

                {{-- Progress Meter dengan Data Kecil --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Data Pelanggan Kecil</h3>
                    <x-progress-meter 
                        id="demo-progress-small"
                        title="Pencatatan Area Desa"
                        :completed="23"
                        :total="45"
                        description="Pencatatan di area desa kecil"
                        period="Juni 2024"
                    />
                </div>
                
            </div>
        </div>

        {{-- Control Panel untuk Testing --}}
        <div class="mt-12 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">
                🎛️ Control Panel - Test Loading Effect
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button onclick="updateProgressMeter('demo-progress-25', 25)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Reload 25%
                </button>
                <button onclick="updateProgressMeter('demo-progress-60', 60)" 
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Reload 60%
                </button>
                <button onclick="updateProgressMeter('demo-progress-85', 85)" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Reload 85%
                </button>
                <button onclick="updateProgressMeter('demo-progress-100', 100)" 
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Reload 100%
                </button>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 text-center">
                Klik tombol di atas untuk melihat efek loading hijau dengan animasi
            </p>
        </div>

        {{-- Info Section --}}
        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                💡 <strong>Tips:</strong> Progress bar akan memiliki efek loading hijau dengan garis-garis bergerak, 
                glow effect, dan text "Memuat..." saat animasi dimulai.
            </p>
        </div>
    </div>

    <script src="{{ asset('js/progress-meter.js') }}"></script>
</body>
</html>
