<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok - Stockify</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1d4ed8; padding-bottom: 12px; }
        .header h1 { font-size: 20px; font-weight: bold; color: #1d4ed8; }
        .header p { font-size: 11px; color: #6b7280; margin-top: 2px; }

        .meta { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 10px; color: #6b7280; }

        .section-title { font-size: 12px; font-weight: bold; color: #374151; margin: 16px 0 8px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead { background-color: #1d4ed8; color: white; }
        thead th { padding: 7px 10px; text-align: left; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        tbody td { padding: 6px 10px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }

        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 9px; font-weight: bold; }
        .badge-red { background-color: #fee2e2; color: #dc2626; }
        .badge-green { background-color: #dcfce7; color: #16a34a; }
        .badge-blue { background-color: #dbeafe; color: #1d4ed8; }

        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 8px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>STOCKIFY</h1>
        <p>Sistem Manajemen Stok Gudang</p>
        <p style="font-size: 14px; font-weight: bold; margin-top: 6px;">
            LAPORAN STOK BARANG
            @if(isset($category) && $category)
                — {{ strtoupper($category->name) }}
            @endif
        </p>
    </div>

    {{-- Meta --}}
    <div class="meta">
        <span>Digenerate: {{ $generatedAt }}</span>
        <span>Total Produk: {{ $produk->count() }}</span>
    </div>

    {{-- Ringkasan per Kategori --}}
    <div class="section-title">Ringkasan per Kategori</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kategori</th>
                <th class="text-center">Total Produk</th>
                <th class="text-center">Total Stok</th>
                <th class="text-center">Stok Menipis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perKategori as $index => $kat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kat->name }}</td>
                    <td class="text-center">{{ $kat->total_produk }}</td>
                    <td class="text-center"><strong>{{ $kat->total_stok }}</strong></td>
                    <td class="text-center">
                        @if($kat->total_menipis > 0)
                            <span class="badge badge-red">{{ $kat->total_menipis }} produk</span>
                        @else
                            <span class="badge badge-green">Aman</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Detail per Produk --}}
    <div class="section-title">Detail Stok per Produk</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>SKU</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th class="text-center">Min. Stok</th>
                <th class="text-center">Stok Saat Ini</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produk as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>{{ $p->supplier->name }}</td>
                    <td class="text-center">{{ $p->minimum_stock }}</td>
                    <td class="text-center"><strong>{{ $p->current_stock }}</strong></td>
                    <td class="text-center">
                        <span class="badge {{ $p->stock_status === 'Menipis' ? 'badge-red' : 'badge-green' }}">
                            {{ $p->stock_status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem Stockify — {{ $generatedAt }}
    </div>

</body>
</html>