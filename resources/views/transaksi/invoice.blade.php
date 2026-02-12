<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaksi->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .invoice-number {
            text-align: center;
            margin-bottom: 15px;
            border: 1px solid #333;
            padding: 8px;
        }
        
        .invoice-number .label {
            font-size: 10px;
            color: #666;
        }
        
        .invoice-number .number {
            font-size: 14px;
            font-weight: bold;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-weight: bold;
            border-bottom: 1px dashed #333;
            padding-bottom: 5px;
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .info-label {
            font-weight: bold;
            flex: 0 0 auto;
            width: 40%;
        }
        
        .info-value {
            text-align: right;
            flex: 1;
            padding-left: 10px;
            word-break: break-word;
        }
        
        table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        
        table thead {
            border-top: 1px dashed #333;
            border-bottom: 1px dashed #333;
        }
        
        table th {
            text-align: left;
            padding: 5px 0;
            font-weight: bold;
            font-size: 10px;
        }
        
        table td {
            padding: 5px 0;
            font-size: 11px;
        }
        
        table td.text-right {
            text-align: right;
        }
        
        .divider {
            border-bottom: 1px dashed #333;
            margin: 10px 0;
        }
        
        .summary {
            margin-bottom: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .summary-row.total {
            font-weight: bold;
            font-size: 13px;
            border-top: 1px dashed #333;
            border-bottom: 1px dashed #333;
            padding: 8px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #333;
            font-size: 10px;
            color: #666;
        }
        
        .footer-text {
            margin-bottom: 5px;
        }
        
        .timestamp {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
            color: #999;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>STRUK PENJUALAN</h1>
            <p>Tanda Terima Transaksi</p>
        </div>
        
        <!-- Invoice Number -->
        <div class="invoice-number">
            <div class="label">No. Invoice</div>
            <div class="number">{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        
        <!-- Informasi Pelanggan -->
        <div class="section">
            <div class="section-title">INFORMASI PELANGGAN</div>
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value">{{ $transaksi->customer->nama ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Telepon</div>
                <div class="info-value">{{ $transaksi->customer->telepon ?? '-' }}</div>
            </div>
        </div>
        
        <!-- Informasi Transaksi -->
        <div class="section">
            <div class="section-title">DETAIL TRANSAKSI</div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $transaksi->produk->nama_produk ?? '-' }}</td>
                        <td class="text-right">{{ $transaksi->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($transaksi->produk->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Ringkasan Pembayaran -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>TOTAL PEMBAYARAN</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Uang Customer</span>
                <span>Rp {{ number_format($transaksi->uang_customer ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>UANG KEMBALIAN</span>
                <span>Rp {{ number_format($transaksi->uang_kembalian ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">Terima kasih atas pembelian Anda!</div>
            <div class="footer-text">Barang yang sudah dibeli tidak dapat ditukar kembali</div>
        </div>
        
        <!-- Timestamp -->
        <div class="timestamp">
            Dicetak: {{ $transaksi->created_at->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
