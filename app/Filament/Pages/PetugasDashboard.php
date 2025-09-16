<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Periode;

class PetugasDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Petugas';
    protected static string $routePath = '/petugas/dashboard';
    protected static string $view = 'filament.pages.petugas-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 2;
    }

    /**
     * Get comprehensive meter reading statistics
     */
    public function getMeterReadingStats(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $totalPelanggan = Pelanggan::count();
        
        $pelangganSudahDicatat = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)
                ->distinct('pelanggan_id')
                ->count('pelanggan_id') : 0;
                
        $pelangganBelumDicatat = $totalPelanggan - $pelangganSudahDicatat;
        $persentaseSelesai = $totalPelanggan > 0 ? round(($pelangganSudahDicatat / $totalPelanggan) * 100) : 0;
        
        // Today's progress
        $pencatatanHariIni = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)
                ->whereDate('created_at', today())
                ->count() : 0;
                
        // Weekly progress
        $pencatatanMingguIni = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count() : 0;
                
        // Average daily target
        $targetHarian = $pelangganBelumDicatat > 0 ? ceil($pelangganBelumDicatat / 7) : 0; // Target 1 minggu
        
        // Total pemakaian air periode ini
        $totalPemakaianPeriode = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)->sum('total_pakai') : 0;
            
        // Rata-rata pemakaian per pelanggan
        $rataRataPemakaian = $pelangganSudahDicatat > 0 ? round($totalPemakaianPeriode / $pelangganSudahDicatat, 2) : 0;
        
        return [
            'total_pelanggan' => $totalPelanggan,
            'sudah_dicatat' => $pelangganSudahDicatat,
            'belum_dicatat' => $pelangganBelumDicatat,
            'persentase' => $persentaseSelesai,
            'pencatatan_hari_ini' => $pencatatanHariIni,
            'pencatatan_minggu_ini' => $pencatatanMingguIni,
            'target_harian' => $targetHarian,
            'total_pemakaian_periode' => $totalPemakaianPeriode,
            'rata_rata_pemakaian' => $rataRataPemakaian,
            'periode_aktif' => $periodeAktif?->nama_periode ?? 'Tidak ada periode aktif',
            'status_text' => $this->getStatusText($persentaseSelesai),
            'status_emoji' => $this->getStatusEmoji($persentaseSelesai),
            'status_color' => $this->getStatusColor($persentaseSelesai)
        ];
    }
    
    /**
     * Get weekly progress data for chart
     */
    public function getWeeklyProgress(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return ['days' => [], 'counts' => []];
        }
        
        $days = [];
        $counts = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D');
            
            $count = Pemakaian::where('periode_id', $periodeAktif->id)
                             ->whereDate('created_at', $date)
                             ->count();
            $counts[] = $count;
        }
        
        return [
            'days' => $days,
            'counts' => $counts
        ];
    }
    
    /**
     * Get pelanggan yang belum dicatat dengan prioritas
     */
    public function getPelangganBelumDicatat(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return [];
        }
        
        // Ambil pelanggan yang belum dicatat periode ini
        $pelangganBelumDicatat = Pelanggan::whereNotIn('id', function($query) use ($periodeAktif) {
            $query->select('pelanggan_id')
                  ->from('pemakaians')
                  ->where('periode_id', $periodeAktif->id);
        })->with('user')
          ->limit(10)
          ->get();
          
        return $pelangganBelumDicatat->map(function($pelanggan) {
            return [
                'id' => $pelanggan->id,
                'nama' => $pelanggan->user->name ?? 'Nama tidak tersedia',
                'alamat' => $pelanggan->alamat ?? 'Alamat tidak tersedia',
                'no_meter' => $pelanggan->no_meter ?? 'N/A'
            ];
        })->toArray();
    }

    /**
     * Get status text based on percentage
     */
    private function getStatusText(int $percentage): string
    {
        if ($percentage >= 100) {
            return 'Pencatatan Selesai';
        } elseif ($percentage >= 75) {
            return 'Hampir Selesai';
        } elseif ($percentage >= 50) {
            return 'Sedang Progress';
        } else {
            return 'Perlu Perhatian';
        }
    }

    /**
     * Get status emoji based on percentage
     */
    private function getStatusEmoji(int $percentage): string
    {
        if ($percentage >= 100) {
            return '✅';
        } elseif ($percentage >= 75) {
            return '🔵';
        } elseif ($percentage >= 50) {
            return '🟡';
        } else {
            return '🔴';
        }
    }

    /**
     * Get status color class based on percentage
     */
    private function getStatusColor(int $percentage): string
    {
        if ($percentage >= 100) {
            return 'text-green-600 dark:text-green-400';
        } elseif ($percentage >= 75) {
            return 'text-blue-600 dark:text-blue-400';
        } elseif ($percentage >= 50) {
            return 'text-yellow-600 dark:text-yellow-400';
        } else {
            return 'text-red-600 dark:text-red-400';
        }
    }

    /**
     * Mount method to pass data to view
     */
    public function mount(): void
    {
        // Data will be available in the view
    }
}
