<?php

namespace App\Services;

use Illuminate\Support\Collection;

class LeadExportService
{
    /**
     * Generate and return a CSV response for leads.
     *
     * @param Collection $leads
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCsv(Collection $leads)
    {
        $filename = "leads_wifa_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama', 'WhatsApp', 'Paket Diminati', 'Status', 'Tanggal Input'];

        $callback = function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($leads as $l) {
                fputcsv($file, [
                    $l->name,
                    $l->whatsapp,
                    $l->package->name ?? '-',
                    strtoupper($l->status),
                    $l->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
