<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket - {{ $pesanan->tiket->nama_tiket }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .print-btn-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .print-btn {
            background: linear-gradient(135deg, #059669, #0891b2);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.5);
        }

        .ticket-wrapper {
            width: 100%;
            max-width: 800px;
            perspective: 1000px;
        }

        .ticket {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1);
            position: relative;
        }

        /* Waterfall Header */
        .ticket-header {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 40%, #0284c7 70%, #0369a1 100%);
            padding: 32px 40px;
            position: relative;
            overflow: hidden;
        }

        .ticket-header.color-reguler {
            background: linear-gradient(135deg, #059669 0%, #10b981 40%, #34d399 100%);
        }

        .ticket-header.color-weekend {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 40%, #60a5fa 100%);
        }

        .ticket-header.color-grup {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 40%, #0284c7 100%);
        }

        .ticket-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1432405972618-c6b0cfba8b42?w=800&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
        }

        .ticket-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 30px;
            background: white;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .brand-text h1 {
            color: white;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .brand-text p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .ticket-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 8px 16px;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        /* Booking Code Section */
        .booking-code-section {
            background: linear-gradient(135deg, #f0fdfa, #ecfeff);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px dashed #d1d5db;
        }

        .booking-code {
            text-align: left;
        }

        .booking-code label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .booking-code .code {
            font-size: 28px;
            font-weight: 800;
            color: #0d9488;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
        }


        /* Ticket Body */
        .ticket-body {
            padding: 32px 40px;
        }

        .ticket-name {
            text-align: center;
            margin-bottom: 28px;
        }

        .ticket-name h2 {
            font-size: 26px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .ticket-name .kategori {
            display: inline-block;
            background: linear-gradient(135deg, #0d9488, #0891b2);
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .ticket-name .kategori.color-reguler {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .ticket-name .kategori.color-weekend {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }

        .ticket-name .kategori.color-grup {
            background: linear-gradient(135deg, #0d9488, #0891b2);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .info-item {
            background: #f9fafb;
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid #f3f4f6;
        }

        .info-item .label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-item .value {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }

        .info-item .value.highlight {
            color: #059669;
            font-size: 20px;
        }

        /* Visitor Info */
        .visitor-info {
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .visitor-icon {
            width: 40px;
            height: 40px;
            background: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .visitor-detail .name {
            font-weight: 700;
            color: #1f2937;
            font-size: 15px;
        }

        .visitor-detail .whatsapp {
            font-size: 12px;
            color: #6b7280;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: repeating-linear-gradient(90deg, #d1d5db, #d1d5db 4px, transparent 4px, transparent 8px);
        }

        .divider span {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        /* Footer */
        .ticket-footer {
            background: #f9fafb;
            border-top: 2px dashed #e5e7eb;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 11px;
            color: #9ca3af;
            line-height: 1.6;
        }

        .footer-left strong {
            color: #6b7280;
            display: block;
            font-size: 12px;
        }

        .footer-right {
            text-align: right;
        }

        .footer-right .total-label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-right .total-value {
            font-size: 24px;
            font-weight: 800;
            color: #059669;
        }

        /* Notches */
        .notch {
            position: absolute;
            width: 24px;
            height: 24px;
            background: #f0f4f8;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .notch-left { left: -12px; }
        .notch-right { right: -12px; }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .print-btn-container {
                display: none !important;
            }

            .ticket-wrapper {
                max-width: 100%;
            }

            .ticket {
                box-shadow: none;
                border-radius: 0;
                page-break-inside: avoid;
            }

            .ticket-header {
                border-radius: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-item,
            .visitor-info,
            .ticket-badge,
            .qr-placeholder,
            .brand-icon,
            .visitor-icon {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @page {
            margin: 10mm;
            size: A4;
        }
    </style>
</head>
<body>
    <div class="print-btn-container">
        <button class="print-btn" onclick="window.print()">
            🖨️ Cetak Tiket
        </button>
    </div>

    <div class="ticket-wrapper">
        <div class="ticket" style="position: relative;">
            <!-- Notches -->
            <div class="notch notch-left"></div>
            <div class="notch notch-right"></div>

            <!-- Header with Waterfall Theme -->
            @php
                $kategoriClass = '';
                $kategori = strtolower($pesanan->tiket->kategori ?? '');
                if (str_contains($kategori, 'reguler')) $kategoriClass = 'color-reguler';
                elseif (str_contains($kategori, 'weekend')) $kategoriClass = 'color-weekend';
                else $kategoriClass = 'color-grup';
            @endphp
            <div class="ticket-header {{ $kategoriClass }}">
                <div class="header-content">
                    <div class="brand">
                        <div class="brand-icon">🌊</div>
                        <div class="brand-text">
                            <h1>Air Terjun Lubuk Hitam</h1>
                            <p>Kota Padang &bull; Sumatera Barat</p>
                        </div>
                    </div>
                    <div class="ticket-badge">
                        ✅ VALID
                    </div>
                </div>
            </div>

            <!-- Booking Code -->
            <div class="booking-code-section">
                <div class="booking-code">
                    <label>Kode Booking</label>
                    <div class="code">LH-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="qr-placeholder">
                    <div class="qr-grid">
                        @php
                            // Generate a deterministic pattern based on booking ID
                            $seed = $pesanan->id;
                            $pattern = [];
                            for ($i = 0; $i < 49; $i++) {
                                $pattern[] = (($seed * ($i + 1) * 7 + $i * 13) % 3) !== 0;
                            }
                        @endphp
                        @foreach($pattern as $filled)
                            <div class="qr-cell {{ $filled ? '' : 'empty' }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="ticket-body">
                <div class="ticket-name">
                    <h2>{{ $pesanan->tiket->nama_tiket }}</h2>
                    <span class="kategori {{ $kategoriClass }}">{{ $pesanan->tiket->kategori }}</span>
                </div>

                <!-- Visitor Info -->
                <div class="visitor-info">
                    <div class="visitor-icon">👤</div>
                    <div class="visitor-detail">
                        <div class="name">{{ $pesanan->user->name }}</div>
                        <div class="whatsapp">{{ $pesanan->user->no_wa }}</div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label">📅 Tanggal Kunjungan</div>
                        <div class="value">{{ $pesanan->tanggal_kunjungan->format('d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">🎫 Jumlah Tiket</div>
                        <div class="value highlight">{{ $pesanan->jumlah }} Tiket</div>
                    </div>
                    <div class="info-item">
                        <div class="label">💰 Harga per Tiket</div>
                        <div class="value">Rp {{ number_format($pesanan->tiket->harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">📋 Status Pesanan</div>
                        <div class="value" style="color: #059669;">✅ Diterima</div>
                    </div>
                </div>

                <div class="divider">
                    <span>Informasi Wisata</span>
                </div>

                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #92400e;">
                    <strong>⚠️ Penting:</strong> Tunjukkan tiket ini saat kedatangan. Tiket hanya berlaku pada tanggal kunjungan yang telah dipilih.
                </div>
            </div>

            <!-- Footer -->
            <div class="ticket-footer">
                <div class="footer-left">
                    <strong>Air Terjun Lubuk Hitam</strong>
                    Kota Padang, Sumatera Barat<br>
                    Buka: Senin-Jumat 08:00-17:00 | Sabtu-Minggu 07:00-18:00
                </div>
                <div class="footer-right">
                    <div class="total-label">Total Pembayaran</div>
                    <div class="total-value">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
