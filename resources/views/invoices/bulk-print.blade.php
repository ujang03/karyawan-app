<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Invoices</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .invoice {
            page-break-after: always;
            margin-bottom: 50px;
        }

        .invoice:last-child {
            page-break-after: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    @foreach($invoices as $invoice)
    <div class="invoice">
        <div class="header">
            <h1>INVOICE - {{ $invoice->title }}</h1>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%;">
                    <strong>Kepada:</strong><br>
                    {{ $invoice->project->client->name }}<br>
                    {{ $invoice->project->client->address ?? '' }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>No. Invoice:</strong> INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <strong>Tanggal:</strong> {{ $invoice->issue_date->format('d/m/Y') }}<br>
                    <strong>Jatuh Tempo:</strong> {{ $invoice->due_date->format('d/m/Y') }}
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->title }}</td>
                    <td>Rp {{ number_format($invoice->total, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: right;">
            <h3>Total: Rp {{ number_format($invoice->total, 2, ',', '.') }}</h3>
        </div>
    </div>
    @endforeach
</body>

</html>