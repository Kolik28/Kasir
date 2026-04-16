<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20mm;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 12px;
        }
        
        .period {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-box {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #999;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        
        .print-date {
            text-align: right;
            margin-bottom: 20px;
            font-size: 11px;
            color: #666;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                padding: 0;
                max-width: 100%;
            }
            page {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN PENJUALAN</h1>
            <p>Aplikasi Kasir Sederhana</p>
        </div>
        
        <div class="print-date">
            Dicetak: {{ now()->format('d-m-Y H:i:s') }}
        </div>
        
        <div class="period">
            Periode: {{ $startDate }} s/d {{ $endDate }}
        </div>
        
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $stats->total_transaksi ?? 0 }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Penjualan</div>
                <div class="stat-value">Rp{{ number_format($stats->total_penjualan ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Rata-rata Penjualan</div>
                <div class="stat-value">Rp{{ number_format($stats->rata_rata_penjualan ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Detail Transaksi -->
        <div class="section-title">DETAIL TRANSAKSI</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Total</th>
                    <th>Metode</th>
                    <th>Items</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $idx => $data)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $data->user->name ?? 'N/A' }}</td>
                        <td class="text-right">Rp{{ number_format($data->subtotal, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp{{ number_format($data->total, 0, ',', '.') }}</strong></td>
                        <td>{{ ucfirst($data->metode_pembayaran) }}</td>
                        <td class="text-center">{{ $data->items->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dicetak dari Aplikasi Kasir</p>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
