<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function printPdf(Invoice $invoice)
    {
        // Load relasi yang diperlukan
        $invoice->load('project.client');

        $pdf = Pdf::loadView('invoices.print', compact('invoice'));

        return $pdf->stream('invoice-' . $invoice->id . '.pdf');

        // Atau untuk download langsung:
        // return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('project.client');

        $pdf = Pdf::loadView('invoices.print', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }

    public function bulkPrint(Request $request)
    {
        $invoiceIds = $request->get('ids', []);
        $invoices = Invoice::with('project.client')
            ->whereIn('id', $invoiceIds)
            ->get();

        $pdf = Pdf::loadView('invoices.bulk-print', compact('invoices'));

        return $pdf->stream('invoices-bulk.pdf');
    }
}
