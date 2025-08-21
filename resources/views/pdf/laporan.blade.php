<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemakaian Air</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, p { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Pemakaian Air</h2>
    <p>
        Periode:
        {{ $periodeAwal->nama_periode }} {{ $periodeAwal->tahun }}
        - {{ $periodeAkhir->nama_periode }} {{ $periodeAkhir->tahun }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total Pemakaian (m³)</th>
                <th>Total Biaya (Rp)</th>
                <th>Sudah Dibayar (Rp)</th>
                <th>Belum Dibayar (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $i => $r)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $r->user->name }}</td>
                    <td>{{ number_format($r->total_pakai_sum, 0, ',', '.') }}</td>
                    <td>{{ number_format(($r->total_pakai_sum * $r->tarif->biaya_per_m3) + ($r->total_periode_count * $r->tarif->beban), 0, ',', '.') }}</td>
                    <td>
                        {{ number_format($r->pemakaians->sum(fn($p) => $p->pembayaran && $p->pembayaran->status === 'lunas' ? $p->pembayaran->jumlah_bayar : 0), 0, ',', '.') }}
                    </td>
                    <td>
                        {{ number_format($r->pemakaians->sum(function($p) use ($r) {
                            if (!$p->pembayaran || $p->pembayaran->status !== 'lunas') {
                                return ($p->total_pakai * $r->tarif->biaya_per_m3) + $r->tarif->beban;
                            }
                            return 0;
                        }), 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
