<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAMTINO - Sistem Informasi Pengelolaan Air Minum</title>
    <meta name="description" content="Sistem Informasi Pengelolaan Air Minum Tino - Solusi digital untuk pengelolaan distribusi air bersih yang efisien dan modern">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .water-animation {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
            background-size: 400% 400%;
            animation: waterFlow 3s ease-in-out infinite;
        }
        @keyframes waterFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200" data-aos="fade-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SIPAMTINO</h1>
                        <p class="text-xs text-gray-600">Air Bersih untuk Semua</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Fitur</a>
                    <a href="#tentang" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Tentang</a>
                    <a href="#kontak" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">Kontak</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/admin/login" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-medium">
                        Masuk Sistem
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-16 gradient-bg min-h-screen flex items-center relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="text-white" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Sistem Informasi
                        <span class="bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">
                            Pengelolaan Air Minum
                        </span>
                    </h1>
                    <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                        SIPAMTINO adalah solusi digital terdepan untuk pengelolaan distribusi air bersih. 
                        Monitoring real-time, pembayaran mudah, dan layanan pelanggan yang responsif.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                <a href="/admin/login" class="bg-white text-purple-600 px-8 py-4 rounded-full font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-center">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition-all duration-300 text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-blue-400/30">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-cyan-300">500+</div>
                            <div class="text-blue-200 text-sm">Pelanggan Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-cyan-300">99.9%</div>
                            <div class="text-blue-200 text-sm">Uptime Sistem</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-cyan-300">24/7</div>
                            <div class="text-blue-200 text-sm">Monitoring</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative z-10 float-animation">
                        <div class="w-full max-w-lg mx-auto">
                            <!-- Main Water Tank Illustration -->
                            <div class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
                                <!-- Water Tank -->
                                <div class="water-animation rounded-2xl h-64 relative overflow-hidden">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <!-- Water Level Animation -->
                                    <div class="absolute bottom-0 left-0 right-0 h-3/4 bg-gradient-to-t from-blue-400 to-cyan-300 opacity-60"></div>
                                </div>
                                
                                <!-- Dashboard Preview -->
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div class="bg-white/20 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-white">1,234</div>
                                        <div class="text-white/80 text-xs">m³ Total</div>
                                    </div>
                                    <div class="bg-white/20 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-white">98%</div>
                                        <div class="text-white/80 text-xs">Efisiensi</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-cyan-300/30 rounded-full animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-300/30 rounded-full animate-pulse" style="animation-delay: 1s"></div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Fitur <span class="text-blue-600">Unggulan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    SIPAMTINO menyediakan berbagai fitur canggih untuk memudahkan pengelolaan sistem air minum dengan efisien dan transparan
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Feature 1: Real-time Monitoring -->
                <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Monitoring Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau penggunaan air secara real-time dengan dashboard yang informatif dan mudah dipahami
                    </p>
                </div>
                
                <!-- Feature 2: Digital Payment -->
                <div class="group bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-emerald-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h6zM4 14a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pembayaran Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem pembayaran yang terintegrasi dengan berbagai metode pembayaran modern dan aman
                    </p>
                </div>
                
                <!-- Feature 3: Customer Service -->
                <div class="group bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-purple-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Layanan Pelanggan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem pengaduan terintegrasi untuk respon cepat terhadap keluhan dan permintaan pelanggan
                    </p>
                </div>
                
                <!-- Feature 4: Data Analytics -->
                <div class="group bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-amber-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Analitik Data</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Laporan dan analisis mendalam untuk optimasi distribusi dan efisiensi penggunaan air
                    </p>
                </div>
                
                <!-- Feature 5: Mobile Friendly -->
                <div class="group bg-gradient-to-br from-rose-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="bg-rose-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zM8 4h4v10H8V4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Friendly</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses sistem kapan saja, dimana saja melalui perangkat mobile dengan antarmuka yang responsif
                    </p>
                </div>
                
                <!-- Feature 6: Security -->
                <div class="group bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                    <div class="bg-indigo-500 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Data pelanggan dan transaksi dilindungi dengan enkripsi tingkat enterprise dan backup otomatis
                    </p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Content -->
                <div data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Tentang <span class="text-blue-600">SIPAMTINO</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        SIPAMTINO (Sistem Informasi Pengelolaan Air Minum Tino) adalah platform digital yang dikembangkan 
                        untuk mempermudah pengelolaan distribusi air bersih. Dengan teknologi modern dan antarmuka yang 
                        user-friendly, kami memastikan pelayanan air bersih yang efisien dan transparan.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Mudah Digunakan</h3>
                                <p class="text-gray-600">Interface yang intuitif dan mudah dipahami oleh semua kalangan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Terintegrasi</h3>
                                <p class="text-gray-600">Semua proses dari pencatatan hingga pembayaran dalam satu sistem</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7.001c0-.682.057-1.35.166-2.002zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan Tinggi</h3>
                                <p class="text-gray-600">Data dilindungi dengan standar keamanan enterprise dan enkripsi end-to-end</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Interactive Demo -->
                <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">
                        <!-- Demo Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Dashboard Preview</h3>
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            </div>
                        </div>
                        
                        <!-- Demo Cards -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl p-4 text-white">
                                <div class="text-2xl font-bold">1,234</div>
                                <div class="text-blue-100 text-sm">Total Pemakaian</div>
                            </div>
                            <div class="bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl p-4 text-white">
                                <div class="text-2xl font-bold">₹ 98.5K</div>
                                <div class="text-emerald-100 text-sm">Pendapatan</div>
                            </div>
                        </div>
                        
                        <!-- Demo Chart -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-end space-x-2 h-24">
                                <div class="bg-blue-400 w-full h-1/2 rounded-t"></div>
                                <div class="bg-blue-500 w-full h-3/4 rounded-t"></div>
                                <div class="bg-blue-600 w-full h-full rounded-t"></div>
                                <div class="bg-blue-500 w-full h-2/3 rounded-t"></div>
                                <div class="bg-blue-400 w-full h-1/3 rounded-t"></div>
                            </div>
                            <div class="text-center text-gray-600 text-sm mt-2">Grafik Pemakaian Bulanan</div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full opacity-20 animate-pulse"></div>
                        <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full opacity-20 animate-pulse" style="animation-delay: 1.5s"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-700 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-200 rounded-full mix-blend-overlay filter blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center text-white mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-4">Mengapa Memilih SIPAMTINO?</h2>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Bergabunglah dengan ribuan pelanggan yang telah merasakan kemudahan pengelolaan air bersih dengan SIPAMTINO
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Benefit 1 -->
                <div class="text-center text-white" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-8 hover:bg-white/30 transition-all duration-300">
                        <div class="w-20 h-20 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Efisiensi Tinggi</h3>
                        <p class="text-blue-100 leading-relaxed">
                            Menghemat waktu dan biaya operasional hingga 40% dengan otomatisasi proses
                        </p>
                    </div>
                </div>
                
                <!-- Benefit 2 -->
                <div class="text-center text-white" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-8 hover:bg-white/30 transition-all duration-300">
                        <div class="w-20 h-20 bg-gradient-to-r from-emerald-400 to-green-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Transparansi Penuh</h3>
                        <p class="text-blue-100 leading-relaxed">
                            Pelanggan dapat memantau penggunaan dan tagihan secara real-time dengan transparansi penuh
                        </p>
                    </div>
                </div>
                
                <!-- Benefit 3 -->
                <div class="text-center text-white" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-8 hover:bg-white/30 transition-all duration-300">
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Layanan Prima</h3>
                        <p class="text-blue-100 leading-relaxed">
                            Dukungan customer service 24/7 dan sistem pengaduan yang responsif
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                Siap untuk Bergabung dengan <span class="text-blue-600">SIPAMTINO</span>?
            </h2>
            <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                Mulai pengalaman pengelolaan air bersih yang lebih modern, efisien, dan transparan hari ini juga
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="/admin/login" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-10 py-4 rounded-full font-semibold text-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    Akses Sistem
                </a>
                <div class="flex items-center space-x-2 text-gray-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm">Keamanan data terjamin</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                
                <!-- Contact Info -->
                <div class="text-white" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-4xl font-bold mb-6">Hubungi Kami</h2>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Tim support SIPAMTINO siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami!
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Telepon</div>
                                <div class="text-gray-300">+62 123 456 7890</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Email</div>
                                <div class="text-gray-300">support@sipamtino.com</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Alamat</div>
                                <div class="text-gray-300">Jl. Air Bersih No. 123, Tino</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-white rounded-3xl shadow-2xl p-8" data-aos="fade-left" data-aos-duration="1000">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="nama@email.com">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Subject</label>
                            <input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Topik pesan Anda">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Pesan</label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-4 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">SIPAMTINO</h3>
                            <p class="text-gray-400 text-sm">Sistem Informasi Pengelolaan Air Minum</p>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-4">
                        Menyediakan solusi digital terpadu untuk pengelolaan sistem air bersih yang efisien, 
                        transparan, dan mudah digunakan oleh semua pihak.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Sistem</h4>
                        <ul class="space-y-3 text-gray-400">
                            <li><a href="/admin" class="hover:text-white transition-colors duration-200">Dashboard Admin</a></li>
                            <li><a href="/admin" class="hover:text-white transition-colors duration-200">Dashboard Petugas</a></li>
                            <li><a href="/admin" class="hover:text-white transition-colors duration-200">Dashboard Pelanggan</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-200">Dokumentasi</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Dukungan</h4>
                        <ul class="space-y-3 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors duration-200">Pusat Bantuan</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-200">FAQ</a></li>
                            <li><a href="#kontak" class="hover:text-white transition-colors duration-200">Hubungi Kami</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-200">Tutorial</a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-8 mt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © 2024 SIPAMTINO. Semua hak cipta dilindungi.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Kebijakan Privasi</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
            
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
