<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:VIP,PLUS,REGULER',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'total_seats' => 'required|integer',
            'price' => 'required|numeric',
            'hotel_mekkah' => 'nullable|string|max:255',
            'hotel_madinah' => 'nullable|string|max:255',
            'airline' => 'nullable|string|max:255',
            'manasik_date' => 'nullable|date',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'itinerary_pdf' => 'nullable|mimes:pdf|max:5120',
            'brosur_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        $validated['remaining_seats'] = $validated['total_seats'];

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->fileUploadService->storeFile($request->file('thumbnail'), 'packages');
        }
        if ($request->hasFile('itinerary_pdf')) {
            $validated['itinerary_pdf'] = $this->fileUploadService->storeFile($request->file('itinerary_pdf'), 'packages/pdfs');
        }
        if ($request->hasFile('brosur_pdf')) {
            $validated['brosur_pdf'] = $this->fileUploadService->storeFile($request->file('brosur_pdf'), 'packages/pdfs');
        }

        Package::create($validated);
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:VIP,PLUS,REGULER',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'total_seats' => 'required|integer',
            'price' => 'required|numeric',
            'hotel_mekkah' => 'nullable|string|max:255',
            'hotel_madinah' => 'nullable|string|max:255',
            'airline' => 'nullable|string|max:255',
            'manasik_date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
            'itinerary_pdf' => 'nullable|mimes:pdf|max:5120',
            'brosur_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('thumbnail')) {
            $this->fileUploadService->deleteFile($package->thumbnail);
            $validated['thumbnail'] = $this->fileUploadService->storeFile($request->file('thumbnail'), 'packages');
        }
        if ($request->hasFile('itinerary_pdf')) {
            $this->fileUploadService->deleteFile($package->itinerary_pdf);
            $validated['itinerary_pdf'] = $this->fileUploadService->storeFile($request->file('itinerary_pdf'), 'packages/pdfs');
        }
        if ($request->hasFile('brosur_pdf')) {
            $this->fileUploadService->deleteFile($package->brosur_pdf);
            $validated['brosur_pdf'] = $this->fileUploadService->storeFile($request->file('brosur_pdf'), 'packages/pdfs');
        }

        $package->update($validated);
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $this->fileUploadService->deleteFile($package->thumbnail);
        $this->fileUploadService->deleteFile($package->itinerary_pdf);
        $this->fileUploadService->deleteFile($package->brosur_pdf);

        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus.');
    }
}