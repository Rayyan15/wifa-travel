<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #1B4332;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1B4332;
        }
        .company-tagline {
            font-size: 12px;
            color: #D4AF37;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .invoice-title {
            font-size: 32px;
            color: #1B4332;
            text-align: right;
            font-weight: bold;
        }
        .invoice-meta {
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .info-section {
            width: 100%;
            margin-bottom: 40px;
        }
        .info-section table {
            width: 100%;
        }
        .info-box {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }
        .info-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 5px;
        }
        .info-detail {
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background-color: #1B4332;
            color: #fff;
            text-align: left;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
        }
        table.items td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            font-size: 16px;
            color: #1B4332;
            background-color: #f0fdf4;
            border-bottom: none;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .badge-paid {
            display: inline-block;
            padding: 5px 15px;
            background-color: #10B981;
            color: #fff;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="company-name">PT. Prima Tiga Satu</div>
                    <div class="company-tagline">Wifa Tour & Travel</div>
                    <div style="font-size: 11px; margin-top: 10px; color: #555;">
                        Gedung Wirausaha Lt. 1<br>
                        Jl. H. R. Rasuna Said Kav. C5, Kuningan<br>
                        Jakarta Selatan - 12920<br>
                        Telp: 021-2251 3531
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-meta">
                        Nomor: {{ $order->order_number }}<br>
                        Tanggal: {{ $order->created_at->format('d/m/Y') }}<br>
                        <br>
                        <span class="badge-paid">LUNAS PADA: {{ $order->updated_at->format('d/m/Y') }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td style="width: 50%; padding-right: 15px;">
                    <div class="info-box">
                        <div class="info-title">Ditagihkan Kepada</div>
                        <div class="info-detail">
                            @if($order->lead)
                                {{ $order->lead->name }}
                            @elseif($order->customer_name)
                                {{ $order->customer_name }}
                            @else
                                -
                            @endif
                        </div>
                        <div style="font-size: 12px; color: #555; margin-top: 5px;">
                            WhatsApp:
                            @if($order->lead)
                                {{ $order->lead->whatsapp ?? '-' }}
                            @elseif($order->customer_phone)
                                {{ $order->customer_phone }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </td>
                <td style="width: 50%; padding-left: 15px;">
                    <div class="info-box">
                        <div class="info-title">Detail Pembayaran</div>
                        <div style="font-size: 12px; color: #555; margin-top: 5px;">
                            Metode: Bank Transfer (BSI / Mandiri)<br>
                            Status: Lunas (Paid)
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Deskripsi Produk</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Kuantitas</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Paket {{ $order->package->type ?? 'Reguler' }} - {{ $order->package->name }}</strong><br>
                    <span style="font-size: 11px; color: #888;">Keberangkatan: {{ \Carbon\Carbon::parse($order->package->departure_date)->translatedFormat('d F Y') }}</span>
                </td>
                <td class="text-right">Rp {{ number_format($order->package->price, 0, ',', '.') }}</td>
                <td class="text-right">1</td>
                <td class="text-right">Rp {{ number_format($order->package->price, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL TAGIHAN</td>
                <td class="text-right">Rp {{ number_format($order->total_amount ?? $order->package->price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Jazakumullah Khairan. Terima kasih atas kepercayaan Anda kepada Wifa Tour & Travel.</p>
        <p style="font-size: 10px; color: #aaa;">Invoice ini dihasilkan secara otomatis oleh sistem dan sah tanpa tanda tangan.</p>
    </div>

</body>
</html>
