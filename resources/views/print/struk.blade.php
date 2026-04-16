<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            background: #f5f5f5;
            padding: 20px;
        }

        .receipt {
            width: 80mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin: 3px 0;
            padding: 2px 0;
        }

        .info-row span:first-child {
            font-weight: bold;
        }

        .divider {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }

        .items {
            margin: 8px 0;
        }

        .item {
            font-size: 11px;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px dotted #ccc;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
            word-wrap: break-word;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #555;
            margin-bottom: 2px;
        }

        .item-subtotal {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            font-weight: bold;
        }

        .summary {
            margin: 8px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            padding: 3px 0;
        }

        .summary-row.total {
            font-size: 13px;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            margin: 5px 0;
        }

        .payment-method {
            text-align: center;
            font-size: 11px;
            padding: 4px 0;
            margin: 4px 0;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            padding-top: 8px;
            border-top: 1px dashed #000;
            margin-top: 8px;
            color: #666;
        }

        .thank-you {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin: 8px 0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                width: 100%;
                max-width: 80mm;
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- HEADER -->
        <div class="header">
            <h1>KASIRKU</h1>
            <p>Toko Kasir Serba Ada</p>
        </div>

        <!-- TRANSACTION INFO -->
        <div class="info-row">
            <span>No. Transaksi:</span>
            <span>#{{ $transaksi->id }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal:</span>
            <span>{{ $transaksi->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span>Jam:</span>
            <span>{{ $transaksi->created_at->format('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span>Kasir:</span>
            <span>{{ $transaksi->user->name ?? 'N/A' }}</span>
        </div>

        <div class="divider"></div>

        <!-- ITEMS -->
        <div class="items">
            @php $no = 1; @endphp
            @foreach ($transaksi->items as $item)
                <div class="item">
                    <div class="item-name">{{ $no }}. {{ $item->produk->nama }}</div>
                    <div class="item-detail">
                        <span>{{ $item->qty }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                    </div>
                    <div class="item-subtotal">
                        <span></span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @php $no++; @endphp
            @endforeach
        </div>

        <div class="divider"></div>

        <!-- SUMMARY -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- PAYMENT METHOD -->
        <div class="payment-method">
            Metode: <strong>{{ ucfirst($transaksi->metode_pembayaran) }}</strong>
        </div>

        <!-- FOOTER -->
        <div class="thank-you">
            ✓ TRANSAKSI SELESAI ✓
        </div>
        <div class="footer">
            Terima kasih telah berbelanja!
            <br>
            {{ $transaksi->created_at->format('d M Y H:i') }}
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
