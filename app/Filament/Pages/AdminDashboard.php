<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Pelanggan, Pemakaian, Pembayaran, Pengaduan, Periode};
use App\Filament\Resources\WidgetResource\Widgets\TurbidityChart;
use App\Filament\Resources\WidgetResource\Widgets\ProgressPencatatanWidget;
use App\Filament\Resources\WidgetResource\Widgets\KeuanganWidget;
use App\Filament\Resources\WidgetResource\Widgets\PemakaianAirChart;
use Carbon\Carbon;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Admin';
    protected static string $routePath = '/dashboard';
    protected static string $view = 'filament.pages.admin-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 1;
    }
    

    public function getPeriodeOptions()
{
    return Periode::orderBy('tahun', 'desc')
        ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
        ->pluck('nama_periode', 'id')
        ->toArray();
}

    protected function getFooterWidgets(): array
    {
        return [            
            TurbidityChart::class,
            PemakaianAirChart::class,
            ProgressPencatatanWidget::class,
            KeuanganWidget::class,        
        ];
    }
    

    /**
     * Get comprehensive system statistics
     */
    public function getSystemStats(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        
        // User Statistics by Role
        $totalUsers = User::count();
        $adminCount = User::where('role_id', 1)->count();
        $petugasCount = User::where('role_id', 2)->count();
        $pelangganCount = User::where('role_id', 3)->count();
        
        // Pelanggan Statistics
        $totalPelanggan = Pelanggan::count();
        $pelangganAktif = Pelanggan::whereHas('user')->count();
        
        // Pengaduan Statistics
        $totalPengaduan = Pengaduan::count();
        $pengaduanBelumDiproses = Pengaduan::where('status', 'Belum Diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $pengaduanBulanIni = Pengaduan::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();
        
        // Pemakaian Air Statistics
        $totalPemakaianSemua = Pemakaian::sum('total_pakai');
        $totalPemakaianBulanIni = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)->sum('total_pakai') : 0;
        $pelangganSudahDicatat = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)
                     ->distinct('pelanggan_id')
                     ->count('pelanggan_id') : 0;
        
        // Revenue Statistics
        $totalPendapatan = Pembayaran::where('status', 'lunas')->sum('jumlah_bayar');
        $pendapatanBulanIni = Pembayaran::where('status', 'lunas')
                                       ->whereMonth('tanggal_bayar', Carbon::now()->month)
                                       ->whereYear('tanggal_bayar', Carbon::now()->year)
                                       ->sum('jumlah_bayar');
        $tagihanBelumBayar = Pembayaran::where('status', 'belum_lunas')->count();

        //calon Pelanggan
        $calonPelangganPending = \App\Models\CalonPelanggan::where('status', 'pending')->count();
        $calonPelangganApproved = \App\Models\CalonPelanggan::where('status', 'approved')->count();
        $calonPelangganRejected = \App\Models\CalonPelanggan::where('status', 'rejected')->count();

        
        return [
            // User Stats
            'total_users' => $totalUsers,
            'admin_count' => $adminCount,
            'petugas_count' => $petugasCount,
            'pelanggan_count' => $pelangganCount,
            
            // Pelanggan Stats  
            'total_pelanggan' => $totalPelanggan,
            'pelanggan_aktif' => $pelangganAktif,
            'pelanggan_sudah_dicatat' => $pelangganSudahDicatat,
            'pelanggan_belum_dicatat' => $totalPelanggan - $pelangganSudahDicatat,
            'progress_pencatatan' => $totalPelanggan > 0 ? round(($pelangganSudahDicatat / $totalPelanggan) * 100) : 0,
            
            // Pengaduan Stats
            'total_pengaduan' => $totalPengaduan,
            'pengaduan_belum_diproses' => $pengaduanBelumDiproses,
            'pengaduan_selesai' => $pengaduanSelesai,
            'pengaduan_bulan_ini' => $pengaduanBulanIni,
            
            // Pemakaian Stats
            'total_pemakaian_semua' => $totalPemakaianSemua,
            'total_pemakaian_bulan_ini' => $totalPemakaianBulanIni,
            
            // Revenue Stats
            'total_pendapatan' => $totalPendapatan,
            'pendapatan_bulan_ini' => $pendapatanBulanIni,
            'tagihan_belum_bayar' => $tagihanBelumBayar,

            //calon pelanggan
            'calon_pelanggan_pending' => $calonPelangganPending,
            'calon_pelanggan_approved' => $calonPelangganApproved,
            'calon_pelanggan_rejected' => $calonPelangganRejected,

            
            // Periode Info
            'periode_aktif' => $periodeAktif?->nama_periode ?? 'Tidak ada periode aktif',
            'tanggal_hari_ini' => Carbon::now()->format('d M Y')

            
        ];
    }

    public function getMonthlyStats(): array
{
    $months = [];
    $pemakaianData = [];

    // Ambil daftar tahun yang tersedia (distinct, urut desc) dan pastikan int
    $availableYears = \App\Models\Periode::select('tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun')
        ->map(fn($y) => (int) $y);
    
    $requestedYear = request()->query('tahun');
    $requestedYear = $requestedYear !== null ? (int) $requestedYear : null;  
    
    if ($requestedYear && $availableYears->contains($requestedYear)) {
        $selectedYear = $requestedYear;
    } elseif ($availableYears->contains((int) now()->year)) {
        $selectedYear = (int) now()->year;
    } else {
        $selectedYear = $availableYears->first() ?? (int) now()->year;
    }  

    // Mapping bulan Indonesia
    $bulanIndonesia = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    for ($month = 1; $month <= 12; $month++) {
        $namaBulan = $bulanIndonesia[$month];
        $months[] = $namaBulan . ' ' . $selectedYear;

        $periode = \App\Models\Periode::whereRaw('LOWER(TRIM(bulan)) = ?', [strtolower($namaBulan)])
            ->where('tahun', $selectedYear)
            ->first();

        $pemakaianBulan = $periode
            ? \App\Models\Pemakaian::where('periode_id', $periode->id)->sum('total_pakai')
            : 0;

        $pemakaianData[] = $pemakaianBulan;
    }

    return [
        'months' => $months,
        'pemakaian_data' => $pemakaianData,
        'selectedYear' => $selectedYear,
        'availableYears' => $availableYears,
    ];
}

     

    

}
