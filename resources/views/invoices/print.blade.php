<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .company-info {
            margin-bottom: 30px;
        }

        .invoice-info {
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .total-section {
            text-align: right;
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            text-align: center;
            color: #666;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INVOICE</h1>
    </div>

    <div class="company-info">
        <h3>AZKA PUTRA CLOTH</h3>
        <p>Jl. Raya Jegang - Serang Baru, Sukasejati, Cikarang Selatan, Bekasi</p>
        <p>Telepon: </p>
        <p>Email: Andre@example.com</p>
    </div>

    <div class="invoice-info">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Kepada:</strong><br>
                    {{ $invoice->project->client->nama }}<br>
                    @if($invoice->project->client->address)
                    {{ $invoice->project->client->address }}<br>
                    @endif
                    @if($invoice->project->client->telp)
                    Tel: {{ $invoice->project->client->telp }}
                    @endif
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <strong>No. Invoice:</strong> INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <strong>Tanggal Invoice:</strong> {{ $invoice->issue_date->format('d/m/Y') }}<br>
                    <strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d/m/Y') }}<br>
                    <strong>Status:</strong>
                    <span class="status {{ $invoice->paid_date ? 'status-paid' : 'status-unpaid' }}">
                        {{ $invoice->paid_date ? 'LUNAS' : 'BELUM LUNAS' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="project-info">
        <strong>Proyek:</strong> {{ $invoice->project->nama }}<br>
        <strong>Deskripsi Proyek:</strong> {{ $invoice->project->description ?? '-' }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Keterangan</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->title }}</td>
                <td>{{ $invoice->detail ?? '-' }}</td>
                <td style="text-align: right;">Rp {{ number_format($invoice->total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <h3>Total: Rp {{ number_format($invoice->total, 2, ',', '.') }}</h3>
        @if($invoice->paid_date)
        <p><strong>Tanggal Pembayaran:</strong> {{ $invoice->paid_date->format('d/m/Y') }}</p>
        @endif
    </div>

    @if($invoice->notes)
    <div class="notes">
        <strong>Catatan:</strong><br>
        {{ $invoice->notes }}
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda kepada kami.</p>
        <p>Invoice ini SAH dan dapat digunakan sebagai bukti pembayaran.</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>