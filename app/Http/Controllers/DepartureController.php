<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Manifest;
use App\Services\DepartureService;
use Illuminate\Http\Request;

class DepartureController extends Controller
{
    protected $departureService;

    public function __construct(DepartureService $departureService)
    {
        $this->departureService = $departureService;
    }
    public function index()
    {
        $packages = Package::withCount(['orders', 'leads'])->latest()->get();
        return view('admin.departures.index', compact('packages'));
    }

    public function show(Package $package)
    {
        $manifests = Manifest::whereHas('order', function($q) use ($package) {
            $q->where('package_id', $package->id);
        })->get();

        $data = $this->departureService->calculateManifestStats($manifests);

        return view('admin.departures.show', [
            'package' => $package,
            'manifests' => $manifests,
            'totalJamaah' => $data['totalJamaah'],
            'stats' => $data['stats'],
            'percentage' => $data['percentage'],
        ]);
    }
}
