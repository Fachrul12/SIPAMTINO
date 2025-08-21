<?php

namespace App\Filament\Pages;

use App\Models\Pelanggan;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\View;

class Laporan extends Page implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Laporan Penggunaan (Per Periode)';
    protected static string $view = 'filament.pages.laporan';

    /**
     * State form (periode_awal & periode_akhir) disimpan di sini.
     */
    public ?array $formData = [
        'periode_awal' => null,
        'periode_akhir' => null,
    ];

    public function mount(): void
    {
        // isi default (opsional)
        $this->form->fill($this->formData);
    }

    public function form(Form $form): Form
    {
        // urutan bulan untuk sorting
        $bulanOrder = "FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')";

        return $form
            ->schema([
                Forms\Components\Select::make('periode_awal')
                    ->label('Periode Awal')
                    ->options(
                        Periode::query()
                            ->orderBy('tahun')
                            ->orderByRaw($bulanOrder)
                            ->pluck('nama_periode', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->live(),

                Forms\Components\Select::make('periode_akhir')
                    ->label('Periode Akhir')
                    ->options(
                        Periode::query()
                            ->orderBy('tahun')
                            ->orderByRaw($bulanOrder)
                            ->pluck('nama_periode', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->live(),
            ])
            ->statePath('formData');
    }

    public function table(Table $table): Table
    {
        return $table
        ->query(function () {
            $awal = data_get($this->formData, 'periode_awal');
            $akhir = data_get($this->formData, 'periode_akhir');
        
            if (!$awal || !$akhir) {
                return Pelanggan::query()->whereRaw('1=0');
            }
        
            $periodeAwal  = Periode::find($awal);
            $periodeAkhir = Periode::find($akhir);
        
            if (!$periodeAwal || !$periodeAkhir) {
                return Pelanggan::query()->whereRaw('1=0');
            }
        
            // urutan bulan biar bisa bandingkan
            $bulanOrder = [
                'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
            ];
        
            $startKey = $periodeAwal->tahun * 12 + $bulanOrder[$periodeAwal->bulan];
            $endKey   = $periodeAkhir->tahun * 12 + $bulanOrder[$periodeAkhir->bulan];
        
            if ($startKey > $endKey) {
                [$startKey, $endKey] = [$endKey, $startKey]; // tukar kalau kebalik
            }
        
            // ambil semua id periode yang masuk range
            $periodeIds = Periode::all()->filter(function ($p) use ($bulanOrder, $startKey, $endKey) {
                $key = $p->tahun * 12 + $bulanOrder[$p->bulan];
                return $key >= $startKey && $key <= $endKey;
            })->pluck('id');
        
            return Pelanggan::query()
                ->with(['user', 'tarif'])
                ->withSum(
                    ['pemakaians as total_pakai_sum' => function ($q) use ($periodeIds) {
                        $q->whereIn('periode_id', $periodeIds);
                    }],
                    'total_pakai'
                )
                ->withCount(
                    ['pemakaians as total_periode_count' => function ($q) use ($periodeIds) {
                        $q->whereIn('periode_id', $periodeIds);
                    }]
                )
                ->with(['pemakaians' => function ($q) use ($periodeIds) {
                    $q->whereIn('periode_id', $periodeIds)
                      ->with('pembayaran');
                }]);
        })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pelanggan')
                    ->sortable()
                    ->searchable(),                

                // Tables\Columns\TextColumn::make('tarif.biaya_per_m3')
                //     ->label('Biaya / m³')
                //     ->money('IDR'),

                Tables\Columns\TextColumn::make('total_pakai_sum')
                    ->label('Total Penggunaan (m³)')
                    ->sortable(),


                Tables\Columns\TextColumn::make('biaya_air')
                    ->label('Biaya Air')
                    ->money('IDR')
                    ->state(function ($record) {
                        $pemakaian = (float) ($record->total_pakai_sum ?? 0);
                        $biaya = (float) ($record->tarif?->biaya_per_m3 ?? 0);
                        return $pemakaian * $biaya;
                    }),

                Tables\Columns\TextColumn::make('total_beban')
                    ->label('Total Beban')
                    ->money('IDR')
                    ->state(function ($record) {
                        $cnt   = (int)   ($record->total_periode_count ?? 0);  // jumlah entry pemakaian pada rentang
                        $beban = (float) ($record->tarif?->beban ?? 0);
                        return $cnt * $beban;
                    }),

                Tables\Columns\TextColumn::make('total_biaya')
                    ->label('Total Biaya')
                    ->money('IDR')
                    ->state(function ($record) {
                        $pemakaian = (float) ($record->total_pakai_sum ?? 0);
                        $biaya     = (float) ($record->tarif?->biaya_per_m3 ?? 0);
                        $cnt       = (int)   ($record->total_periode_count ?? 0);
                        $beban     = (float) ($record->tarif?->beban ?? 0);
                        return ($pemakaian * $biaya) + ($cnt * $beban);
                    }),

                Tables\Columns\TextColumn::make('sudah_dibayar')
                    ->label('Sudah Dibayar')
                    ->money('IDR')
                    ->state(function ($record) {
                        // jumlah_bayar dari pembayaran yang status = 'lunas'
                        return (float) $record->pemakaians->sum(function ($p) {
                            $pay = $p->pembayaran;
                            return ($pay && $pay->status === 'lunas')
                                ? (float) ($pay->jumlah_bayar ?? 0)
                                : 0.0;
                        });
                    }),

                Tables\Columns\TextColumn::make('belum_dibayar')
                    ->label('Belum Dibayar')
                    ->money('IDR')
                    ->state(function ($record) {
                        $tarif = $record->tarif;
                        return (float) $record->pemakaians->sum(function ($p) use ($tarif) {
                            $pay = $p->pembayaran;
                            // Jika belum ada pembayaran atau status != lunas, anggap belum dibayar = tagihan periode tsb
                            if (!$pay || $pay->status !== 'lunas') {
                                $biayaPerM3 = (float) ($tarif?->biaya_per_m3 ?? 0);
                                $beban      = (float) ($tarif?->beban ?? 0);
                                $total      = ((int)$p->total_pakai * $biayaPerM3) + $beban;
                                return $total;
                            }
                            return 0.0;
                        });
                    }),
            ])
            ->defaultSort('user.name');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $awal = data_get($this->formData, 'periode_awal');
                    $akhir = data_get($this->formData, 'periode_akhir');

                    if (!$awal || !$akhir) {
                        Notification::make()
                            ->title('Periode belum dipilih')
                            ->body('Silakan pilih periode awal dan akhir terlebih dahulu.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Query yang sama dengan table()
                    $query = $this->table->getQuery();
                    $records = $query->get();

                    // Load view laporan
                    $pdf = Pdf::loadView('pdf.laporan', [
                        'records' => $records,
                        'periodeAwal' => \App\Models\Periode::find($awal),
                        'periodeAkhir' => \App\Models\Periode::find($akhir),
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'laporan-periode.pdf'
                    );
                }),
        ];
    }
}
