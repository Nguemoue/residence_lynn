<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Invokable controller to generate and download a PDF for an order.
 *
 * This controller handles requests to download a PDF representation of an order
 * identified by its UUID. It uses the Dompdf library to render a Blade template
 * with Tailwind CSS styling and returns the PDF as a downloadable response.
 */
final class DownloadOrderPdfController
{
    /**
     * Generate and download the PDF for the specified order.
     *
     * @param string $uuid The UUID of the order to generate the PDF for.
     * @return Response The PDF file as a downloadable response.
     * @throws NotFoundHttpException If the order is not found.
     */
    public function __invoke(Order $order): Response
    {
        $order->loadMissing('items.product');
        // Generate PDF using Blade template
        $pdf = Pdf::loadView('pdf.order', [
            'order' => $order,
            'formatPrice' => fn (float $value): string => number_format($value, 2, ',', ' ') . ' €',
        ]);

        // Set PDF options for better rendering
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        // Return PDF as a downloadable file
        return \response($pdf->output())->header('content-type','application/pdf');
        //return $pdf->download("commande-{$order->uuid}.pdf");
    }
}
