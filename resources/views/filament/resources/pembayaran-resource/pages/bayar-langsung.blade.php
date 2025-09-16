<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Card dengan informasi -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-lg p-6 border border-blue-200 dark:border-gray-600">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pembayaran Langsung</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Pilih pelanggan dan periode yang belum lunas, kemudian proses pembayaran
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
            <div class="p-6">
                <form wire:submit="prosessPembayaran">
                    {{ $this->form }}
                    
                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach($this->getFormActions() as $action)
                            {{ $action }}
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200">Petunjuk Penggunaan</h4>
                    <div class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pilih nama pelanggan yang akan melakukan pembayaran</li>
                            <li>Pilih periode yang belum lunas untuk pelanggan tersebut</li>
                            <li>Masukkan jumlah uang yang diberikan pelanggan</li>
                            <li>Sistem akan menghitung kembalian secara otomatis</li>
                            <li>Klik "Proses Pembayaran" untuk menyelesaikan transaksi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
