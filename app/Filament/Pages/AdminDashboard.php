<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Pelanggan, Pemakaian, Pembayaran, Pengaduan, Periode};
use App\Filament\Resources\WidgetResource\Widgets\TurbidityChart;
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

    protected function getHeaderWidgets(): array
    {
        return [
            TurbidityChart::class,
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
            
            // Periode Info
            'periode_aktif' => $periodeAktif?->nama_periode ?? 'Tidak ada periode aktif',
            'tanggal_hari_ini' => Carbon::now()->format('d M Y')
        ];
    }

    /**
     * Get monthly statistics for charts
     */
    public function getMonthlyStats(): array
    {
        $months = [];
        $pemakaianData = [];
        $pendapatanData = [];
        $pengaduanData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            // Pemakaian per bulan
            $periode = Periode::where('nama_periode', 'like', '%' . $date->format('M Y') . '%')
                             ->orWhere('nama_periode', 'like', '%' . $date->format('F Y') . '%')
                             ->first();
            $pemakaianBulan = $periode ? Pemakaian::where('periode_id', $periode->id)->sum('total_pakai') : 0;
            $pemakaianData[] = $pemakaianBulan;
            
            // Pendapatan per bulan
            $pendapatanBulan = Pembayaran::where('status', 'lunas')
                                        ->whereMonth('tanggal_bayar', $date->month)
                                        ->whereYear('tanggal_bayar', $date->year)
                                        ->sum('jumlah_bayar');
            $pendapatanData[] = $pendapatanBulan;
            
            // Pengaduan per bulan
            $pengaduanBulan = Pengaduan::whereMonth('created_at', $date->month)
                                      ->whereYear('created_at', $date->year)
                                      ->count();
            $pengaduanData[] = $pengaduanBulan;
        }
        
        return [
            'months' => $months,
            'pemakaian_data' => $pemakaianData,
            'pendapatan_data' => $pendapatanData,
            'pengaduan_data' => $pengaduanData
        ];
    }
}
