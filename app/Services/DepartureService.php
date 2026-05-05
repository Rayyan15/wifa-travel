<?php

namespace App\Services;

use Illuminate\Support\Collection;

class DepartureService
{
    /**
     * Calculate statistics and completion percentage for a given collection of manifests.
     *
     * @param Collection $manifests
     * @return array
     */
    public function calculateManifestStats(Collection $manifests): array
    {
        $totalJamaah = $manifests->count();
        
        $stats = [
            'passport' => $manifests->where('doc_passport_ok', true)->count(),
            'photo' => $manifests->where('doc_photo_ok', true)->count(),
            'nik' => $manifests->where('doc_nik_ok', true)->count(),
            'buku_nikah' => $manifests->filter(function($m) {
                return $m->marital_status === 'Nikah' ? $m->doc_buku_nikah_ok : true;
            })->count(),
        ];

        $totalRequired = 0;
        $totalDone = 0;

        foreach ($manifests as $m) {
            $totalRequired += 3;
            if ($m->doc_passport_ok) $totalDone++;
            if ($m->doc_photo_ok) $totalDone++;
            if ($m->doc_nik_ok) $totalDone++;

            if ($m->marital_status === 'Nikah') {
                $totalRequired += 1;
                if ($m->doc_buku_nikah_ok) $totalDone++;
            }
        }

        $percentage = $totalRequired > 0 ? (int)round(($totalDone / $totalRequired) * 100) : 0;

        return compact('totalJamaah', 'stats', 'percentage');
    }
}
