<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - Air Terjun Lubuk Hitam</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
            padding: 30px;
        }

        /* Kop Laporan */
        .kop-laporan {
            text-align: center;
            padding: 20px 30px 16px;
            margin-bottom: 20px;
            border-bottom: 3px double #0d9488;
        }

        .kop-laporan .kop-nama {
            font-size: 18px;
            font-weight: 800;
            color: #0d9488;
            letter-spacing: 1px;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .kop-laporan .kop-alamat {
            font-size: 11px;
            color: #4b5563;
            line-height: 1.4;
        }

        .kop-laporan .kop-judul {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
            margin-top: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-laporan .kop-garis {
            width: 100%;
            height: 0;
            border: none;
            border-top: 3px double #0d9488;
            margin-top: 14px;
        }

        /* Period Info */
        .period-info {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .period-info span {
            font-weight: 600;
            color: #0d9488;
        }

        /* Summary Cards */
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }

        .summary-card {
            display: table-cell;
            width: 50%;
            padding: 16px 20px;
            border-radius: 10px;
        }

        .summary-card:first-child {
            padding-right: 10px;
        }

        .summary-card:last-child {
            padding-left: 10px;
        }

        .card-pendapatan {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #a7f3d0;
        }

        .card-tiket {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #93c5fd;
        }

        .card-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .card-value {
            font-size: 22px;
            font-weight: 800;
        }

        .card-value.green { color: #059669; }
        .card-value.blue { color: #2563eb; }

        /* Table */
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #0d9488;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 9px;
        }

        table thead {
            background: linear-gradient(135deg, #0d9488, #0891b2);
            color: white;
        }

        table thead th {
            padding: 6px 5px;
            text-align: left;
            font-weight: 600;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table thead th:first-child {
            border-radius: 6px 0 0 0;
        }

        table thead th:last-child {
            border-radius: 0 6px 0 0;
        }

        table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table tbody td {
            padding: 5px;
            vertical-align: middle;
        }

        table tbody tr:last-child {
            border-bottom: 2px solid #0d9488;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }
        .text-green { color: #059669; }

        /* Total Row */
        .total-row {
            background: #f0fdfa !important;
            font-weight: 700;
        }

        .total-row td {
            padding: 12px !important;
            font-size: 12px;
            border-top: 2px solid #0d9488;
        }

        /* Revenue Table */
        .revenue-table thead {
            background: linear-gradient(135deg, #0891b2, #0284c7);
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
            width: 50%;
            font-size: 10px;
            color: #9ca3af;
        }

        .footer-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            font-size: 10px;
            color: #9ca3af;
        }

        .signature-box {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-left {
            display: table-cell;
            width: 50%;
            text-align: center;
            font-size: 11px;
        }

        .signature-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            font-size: 11px;
        }

        .signature-space {
            height: 60px;
        }

        .signature-line {
            border-top: 1px solid #374151;
            display: inline-block;
            padding: 0 30px;
            margin-top: 2px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
        }

        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 8px;
            color: #d1d5db;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    

    <!-- Kop Laporan -->
    <div class="kop-laporan">
        <div class="kop-nama">Objek Wisata Air Terjun Lubuk Hitam</div>
        <div class="kop-alamat">
            Kelurahan Teluk Kabung Utara, Kecamatan Bungus Teluk Kabung<br>
            Kota Padang, Sumatera Barat
        </div>
        <div class="kop-judul">Laporan Penjualan Tiket Wisata</div>
        <hr class="kop-garis">
    </div>

    <!-- Period -->
    <div class="period-info">
        Periode: <span>{{ \Carbon\Carbon::parse($startDate)->format('d F Y') }}</span> &mdash; <span>{{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</span>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-card card-pendapatan">
            <div class="card-label">Total Pendapatan</div>
            <div class="card-value green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card card-tiket">
            <div class="card-label">Total Tiket Terjual</div>
            <div class="card-value blue">{{ $totalTiketTerjual }}</div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="section-title">Detail Pesanan</div>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="7%">Kode</th>
                <th width="12%">Pengunjung</th>
                <th width="10%">WhatsApp</th>
                <th width="14%">Tiket</th>
                <th width="9%">Tgl Kunjungan</th>
                <th width="5%" class="text-center">Qty</th>
                <th width="13%" class="text-right">Total</th>
                <th width="8%" class="text-center">Status</th>
                <th width="9%">Tgl Pesan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>#{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="font-bold">{{ $p->user->name }}</td>
                <td>{{ $p->user->no_wa }}</td>
                <td>{{ $p->tiket->nama_tiket }}</td>
                <td>{{ $p->tanggal_kunjungan->format('d-m-Y') }}</td>
                <td class="text-center">{{ $p->jumlah }}</td>
                <td class="text-right font-bold text-green">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                <td class="text-center">{{ ucfirst($p->status) }}</td>
                <td>{{ $p->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="no-data">Tidak ada data pesanan pada periode ini</td>
            </tr>
            @endforelse
            @if($pesanans->count() > 0)
            <tr class="total-row">
                <td colspan="6" class="text-align left">TOTAL (Diterima)</td>
                <td class="text-center font-bold">{{ $totalTiketTerjual }}</td>
                <td class="text-right font-bold text-green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Revenue Per Day -->
    @if($pendapatanPerHari->count() > 0)
    <div class="section-title">Pendapatan Per Hari</div>
    <table class="revenue-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="45%">Tanggal</th>
                <th width="45%" class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendapatanPerHari as $index => $d)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d F Y') }}</td>
                <td class="text-right font-bold text-green">Rp {{ number_format($d->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            @if($pesanans->count() > 0)
            <tr class="total-row">
                <td colspan="" class="text-align left">TOTAL</td>
                <td class="text-center font-bold"></td>
                <td class="text-right font-bold text-green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif

    <!-- Signature -->
    <div class="signature-box">
        <div class="signature-right">
            <p>Kota Padang, {{ now()->format('d F Y') }}</p>
            <p><strong>Admin</strong></p>
            <div class="signature-space"></div>
            <div class="signature-line">Air Terjun Lubuk Hitam</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            Dokumen ini dicetak secara otomatis oleh sistem.<br>
            Air Terjun Lubuk Hitam &copy; {{ date('Y') }}
        </div>
        <div class="footer-right">
            Dicetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
    </div>
</body>
</html>
