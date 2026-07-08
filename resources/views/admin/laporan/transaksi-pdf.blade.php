<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi — Stockify</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1d4ed8; padding-bottom: 12px; }
        .header h1 { font-size: 20px; font-weight: bold; color: #1d4ed8; }
        .header p { font-size: 11px; color: #6b7280; margin-top: 2px; }

        .meta { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 10px; color: #6b7280; }

        .summary { display: flex; gap: 12px; margin-bottom: 16px; }
        .summary-card { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; text-align: center; }
        .summary-card .label { font-size: 9px; color: #6b7280; margin-bottom: 4px; }
        .summary-card .value { font-size: 18px; font-weight: bold; }
        .value-green { color: #16a34a; }
        .value-red { color: #dc2626; }
        .value-yellow { color: #d97706; }
        .value-gray { color: #6b7280; }

        .section-title { font-size: 12px; font-weight: bold; color: #374151; margin: 16px 0 8px; }

        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #1d4ed8; color: white; }
        thead th { padding: 7px 8px; text-align: left; font-size: 9px; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        tbody td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; font-size: 9px; }

        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 9999px; font-size: 8px; font-weight: bold; }
        .badge-green { background-color: #dcfce7; color: #16a34a; }
        .badge-red { background-color: #fee2e2; color: #dc2626; }
        .badge-blue { background-color: #dbeafe; color: #1d4ed8; }
        .badge-yellow { background-color: #fef9c3; color: #d97706; }
        .badge-gray { background-color: #f3f4f6; color: #6b7280; }

        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 8px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>STOCKIFY</h1>
        <p>Sistem Manajemen Stok Gudang</p>
        <p style="font-size: 14px; font-weight: bold; margin-top: 6px;">LAPORAN TRANSAKSI STOK</p>
        @if(!empty($filters['date_from']) || !empty($filters['date_to']))
            <p style="font-size: 11px; color: #374151; margin-top: 4px;">
                Periode:
                {{ !empty($filters['date_from']) ? \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') : 'Awal' }}
                —
                {{ !empty($filters['date_to']) ? \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') : 'Sekarang' }}
            </p>
        @endif
    </div>

    <div class="meta">
        <span>Digenerate: {{ $generatedAt }}</span>
        <span>Total Transaksi: {{ $transactions->count() }}</span>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Masuk (Diterima)</div>
            <div class="value value-green">{{ $summary['totalMasuk'] }}</div>
            <div class="label">unit</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Keluar (Dikeluarkan)</div>
            <div class="value value-red">{{ $summary['totalKeluar'] }}</div>
            <div class="label">unit</div>
        </div>
        <div class="summary-card">
            <div class="label">Masih Pending</div>
            <div class="value value-yellow">{{ $summary['totalPending'] }}</div>
            <div class="label">transaksi</div>
        </div>
        <div class="summary-card">
            <div class="label">Ditolak</div>
            <div class="value value-gray">{{ $summary['totalDitolak'] }}</div>
            <div class="label">transaksi</div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="section-title">Detail Transaksi</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>SKU</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Jumlah</th>
                <th>Oleh</th>
                <th>Tanggal</th>
                <th>Catatan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trx->product->name ?? '—' }}</td>
                    <td>{{ $trx->product->sku ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $trx->type === 'Masuk' ? 'badge-green' : 'badge-red' }}">
                            {{ $trx->type }}
                        </span>
                    </td>
                    <td class="text-center" style="font-weight: bold; color: {{ $trx->type === 'Masuk' ? '#16a34a' : '#dc2626' }}">
                        {{ $trx->type === 'Masuk' ? '+' : '-' }}{{ $trx->quantity }}
                    </td>
                    <td>{{ $trx->user->name ?? '—' }}</td>
                    <td>{{ $trx->date?->format('d M Y') ?? '—' }}</td>
                    <td>{{ Str::limit($trx->notes ?? '—', 30) }}</td>
                    <td class="text-center">
                        @php
                            $badgeClass = match($trx->status) {
                                'Pending'     => 'badge-yellow',
                                'Diterima'    => 'badge-green',
                                'Dikeluarkan' => 'badge-blue',
                                'Ditolak'     => 'badge-red',
                                default       => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $trx->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem Stockify — {{ $generatedAt }}
    </div>

</body>
</html>