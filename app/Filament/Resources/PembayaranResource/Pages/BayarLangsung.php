<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use App\Models\Pelanggan;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class BayarLangsung extends Page
{
    protected static string $resource = PembayaranResource::class;

    protected static string $view = 'filament.resources.pembayaran-resource.pages.bayar-langsung';

    public ?array $data = [];
    
    public function getTitle(): string
    {
        return 'Pembayaran Langsung';
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
Forms\Components\Section::make('Data Pelanggan')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('pelanggan_id')
                                    ->label('Nama Pelanggan')
                                    ->options(function () {
                                        // Ambil pelanggan yang memiliki tagihan belum lunas
                                        return Pembayaran::with(['pemakaian.pelanggan.user'])
                                            ->where('status', 'belum_lunas')
                                            ->get()
                                            ->pluck('pemakaian.pelanggan.user.name', 'pemakaian.pelanggan.id')
                                            ->unique()
                                            ->sort();
                                    })
                                    ->searchable()
                                    ->placeholder('Pilih pelanggan...')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('periode_id', null);
                                        $set('jumlah_bayar', null);
                                        $set('jumlah_dibayar', null);
                                        $set('kembalian', null);
                                        $set('pemakaian_id', null);
                                        $set('pembayaran_id', null);
                                    }),

                                Forms\Components\Select::make('periode_id')
                                    ->label('Periode yang Belum Lunas')
                                    ->options(function (callable $get) {
                                        $pelangganId = $get('pelanggan_id');
                                        if (!$pelangganId) {
                                            return [];
                                        }

                                        return Pembayaran::with(['periode', 'pemakaian'])
                                            ->whereHas('pemakaian', function ($query) use ($pelangganId) {
                                                $query->where('pelanggan_id', $pelangganId);
                                            })
                                            ->where('status', 'belum_lunas')
                                            ->get()
                                            ->pluck('periode.nama_periode', 'periode.id')
                                            ->sort()
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->placeholder('Pilih periode...')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        $pelangganId = $get('pelanggan_id');
                                        if ($state && $pelangganId) {
                                            $pembayaran = Pembayaran::with('pemakaian')
                                                ->where('periode_id', $state)
                                                ->whereHas('pemakaian', function ($query) use ($pelangganId) {
                                                    $query->where('pelanggan_id', $pelangganId);
                                                })
                                                ->where('status', 'belum_lunas')
                                                ->first();

                                            if ($pembayaran) {
                                                $set('jumlah_bayar', $pembayaran->jumlah_bayar);
                                                $set('pemakaian_id', $pembayaran->pemakaian_id);
                                                $set('pembayaran_id', $pembayaran->id);
                                                $set('jumlah_dibayar', null);
                                                $set('kembalian', null);
                                            }
                                        }
                                    }),
                            ]),
                    ])
                    ->columnSpanFull(),

Forms\Components\Section::make('Detail Tagihan')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('jumlah_bayar')
                                    ->label('Jumlah Tagihan')
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '0')
                                    ->extraAttributes(['class' => 'text-lg font-semibold']),

                                Forms\Components\TextInput::make('jumlah_dibayar')
                                    ->label('Jumlah Dibayar')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Masukkan jumlah uang yang diberikan')
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        $jumlahTagihan = $get('jumlah_bayar') ?? 0;
                                        $kembalian = max(0, (float)$state - (float)$jumlahTagihan);
                                        $set('kembalian', $kembalian);
                                    })
                                    ->extraAttributes(['class' => 'text-lg']),

                                Forms\Components\TextInput::make('kembalian')
                                    ->label('Kembalian')
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '0')
                                    ->extraAttributes(['class' => 'text-lg font-semibold text-green-600']),
                            ]),

                        Forms\Components\Hidden::make('pemakaian_id'),
                        Forms\Components\Hidden::make('pembayaran_id'),
                    ])
                    ->columnSpanFull()
                    ->visible(fn (callable $get) => $get('jumlah_bayar')),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('bayar')
                ->label('Proses Pembayaran')
                ->icon('heroicon-o-credit-card')
                ->color('success')
                ->size('lg')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Pembayaran')
                ->modalDescription(fn () => 
                    'Apakah Anda yakin ingin memproses pembayaran sebesar Rp ' . 
                    number_format($this->data['jumlah_bayar'] ?? 0, 0, ',', '.') . '?'
                )
                ->modalSubmitActionLabel('Ya, Proses Pembayaran')
                ->action('prosessPembayaran')
                ->visible(fn () => 
                    !empty($this->data['jumlah_bayar']) && 
                    !empty($this->data['jumlah_dibayar']) && 
                    $this->data['jumlah_dibayar'] >= $this->data['jumlah_bayar']
                ),

        ];
    }

    public function prosessPembayaran(): void
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();
            
            if (empty($data['pembayaran_id'])) {
                throw new \Exception('Data pembayaran tidak ditemukan.');
            }

            if (!isset($data['jumlah_bayar']) || !isset($data['jumlah_dibayar']) || !isset($data['kembalian'])) {
                throw new \Exception('Data pembayaran tidak lengkap.');
            }

            if ((float)$data['jumlah_dibayar'] < (float)$data['jumlah_bayar']) {
                throw new \Exception('Jumlah yang dibayar kurang dari tagihan.');
            }

            // Update status pembayaran
            $pembayaran = Pembayaran::find($data['pembayaran_id']);
            
            if (!$pembayaran) {
                throw new \Exception('Data pembayaran tidak ditemukan.');
            }

            if ($pembayaran->status === 'lunas') {
                throw new \Exception('Pembayaran sudah lunas.');
            }

            $pembayaran->update([
                'jumlah_dibayar' => $data['jumlah_dibayar'],
                'kembalian' => $data['kembalian'],
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

            DB::commit();

            // Reset form
            $this->data = [];
            $this->form->fill();

            Notification::make()
                ->title('Pembayaran Berhasil!')
                ->body(sprintf(
                    'Pembayaran untuk %s periode %s telah berhasil diproses. Kembalian: Rp %s',
                    $pembayaran->pemakaian->pelanggan->user->name ?? 'N/A',
                    $pembayaran->periode->nama_periode ?? 'N/A',
                    number_format($data['kembalian'] ?? 0, 0, ',', '.')
                ))
                ->success()
                ->duration(5000)
                ->send();

        } catch (\Exception $e) {
            DB::rollBack();
            
            Notification::make()
                ->title('Pembayaran Gagal!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('lihat_riwayat')
                ->label('Lihat Riwayat Pembayaran')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('gray')
                ->url(fn (): string => static::getResource()::getUrl('list')),
        ];
    }
}
