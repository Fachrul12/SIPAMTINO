<x-filament-panels::page.simple>
    <!-- Modern split-screen design -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-800 lg:grid lg:grid-cols-2">
        
        <!-- Left side - Brand/Visual Section -->
        {{-- <div class="hidden lg:flex lg:flex-col lg:justify-center lg:items-center bg-gradient-to-br from-purple-600 via-violet-600 to-indigo-700 relative overflow-hidden">
            <!-- Animated background shapes -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-32 right-16 w-48 h-48 bg-purple-300/20 rounded-full blur-2xl animate-bounce"></div>
                <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-violet-400/30 rounded-full blur-xl animate-ping"></div>
            </div>
            
            <div class="relative z-10 text-center text-white max-w-md px-8">
                <!-- Large logo with glow -->
                <div class="mb-12">
                    <div class="relative inline-block">
                        <div class="absolute inset-0 bg-white/20 rounded-3xl blur-2xl scale-110"></div>
                        <div class="relative bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/20">
                            <img src="{{ asset('logo.png') }}" alt="SIPAMTINO" class="h-24 w-24 mx-auto object-contain">
                        </div>
                    </div>
                </div>
                
                <!-- Brand messaging -->
                <h1 class="text-5xl font-black mb-6 leading-tight">
                    SIPAMTINO
                </h1>
                <p class="text-xl font-dark mb-8 text-white/90">
                    Sistem Informasi Pengelolaan
                    <span class="font-semibold">Air Minum Terpadu</span>
                </p>
                
                <!-- Features highlight -->
                <div class="space-y-4 text-left">
                    <div class="flex items-center text-white/80">
                        <div class="w-2 h-2 bg-white rounded-full mr-4"></div>
                        <span class="text-sm font-medium">Kelola pelanggan dengan mudah</span>
                    </div>
                    <div class="flex items-center text-white/80">
                        <div class="w-2 h-2 bg-white rounded-full mr-4"></div>
                        <span class="text-sm font-medium">Monitoring penggunaan real-time</span>
                    </div>
                    <div class="flex items-center text-white/80">
                        <div class="w-2 h-2 bg-white rounded-full mr-4"></div>
                        <span class="text-sm font-medium">Laporan otomatis dan akurat</span>
                    </div>
                </div>
            </div>
        </div> --}}
        
        <!-- Right side - Login Form -->
        <div class="flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:max-w-md">
                
                <!-- Mobile logo (hidden on desktop) -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-block p-4 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-lg">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-12 object-contain">
                    </div>
                </div>
                
                <!-- Welcome section -->
                <div class="mb-10 ">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Selamat datang!
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        Masuk ke akun SIPAMTINO Anda
                    </p>
                </div>
                
                <!-- Login form -->
                <form wire:submit.prevent="authenticate" class="space-y-8">
                    <div class="space-y-6">
                        {{ $this->form }}
                    </div>
                    
                    <!-- Submit button -->
                    <div class="space-y-6">
                        <x-filament::button 
                            type="submit"
                            form="login"
                            class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 font-semibold text-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl group"
                        >
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Masuk Dashboard
                            </span>
                        </x-filament::button>
                        
                        <!-- Alternative actions -->
                        <div class="text-center space-y-4">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">atau</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('landing') }}" class="w-full inline-flex justify-center items-center px-6 py-3 border-2 border-purple-300 dark:border-purple-600 rounded-2xl text-purple-600 dark:text-purple-400 bg-white dark:bg-gray-800 hover:bg-purple-50 dark:hover:bg-purple-900/20 font-medium transition-all duration-200 hover:scale-[1.02] group">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z"/>
                                </svg>
                                Buat Akun Baru
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- User roles info -->
                <div class="mt-12 p-6 bg-gray-100 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">
                        🎯 Jenis Akun
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <span class="text-purple-600 mr-3">👑</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Admin</span>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Full access</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <span class="text-indigo-600 mr-3">🛠️</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Petugas</span>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Manage customers</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <span class="text-violet-600 mr-3">👤</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Pelanggan</span>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">View bills</span>
                        </div>
                    </div>
                </div>
                
                <!-- Back link -->
                <div class="mt-8 text-center">
                    <a href="{{ route('landing') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 font-medium transition-colors group">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Kembali ke beranda
                    </a>
                </div>
                
                <!-- Footer info -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        © 2024 SIPAMTINO • v1.0 • Made with ❤️
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page.simple>
