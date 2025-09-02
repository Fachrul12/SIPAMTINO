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
     * Get progress data for the current active period
     */
    public function getProgressData(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $totalPelanggan = Pelanggan::count();
        
        $pelangganSudahDicatat = $periodeAktif ? 
            Pemakaian::where('periode_id', $periodeAktif->id)
                ->distinct('pelanggan_id')
                ->count('pelanggan_id') : 0;
                
        $pelangganBelumDicatat = $totalPelanggan - $pelangganSudahDicatat;
        $persentaseSelesai = $totalPelanggan > 0 ? round(($pelangganSudahDicatat / $totalPelanggan) * 100) : 0;
        
        return [
            'total_pelanggan' => $totalPelanggan,
            'sudah_dicatat' => $pelangganSudahDicatat,
            'belum_dicatat' => $pelangganBelumDicatat,
            'persentase' => $persentaseSelesai,
            'periode_aktif' => $periodeAktif?->nama_periode ?? 'Tidak ada periode aktif',
            'status_text' => $this->getStatusText($persentaseSelesai),
            'status_emoji' => $this->getStatusEmoji($persentaseSelesai),
            'status_color' => $this->getStatusColor($persentaseSelesai)
        ];
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
