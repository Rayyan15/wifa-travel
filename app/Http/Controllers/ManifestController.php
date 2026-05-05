<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use App\Models\Package;
use App\Models\RoomList;
use App\Models\BusSeater;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ManifestController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::where('is_active', true)->get();
        $selectedPackage = $request->package_id;

        $query = Manifest::with(['order.package', 'order.lead', 'roomList', 'busSeater'])->latest();
        
        if ($selectedPackage) {
            $query->whereHas('order', function($q) use ($selectedPackage) {
                $q->where('package_id', $selectedPackage);
            });
        }

        $manifests = $query->paginate(15);
        $manifests->appends(['package_id' => $selectedPackage]); // append query param
        
        $rooms = RoomList::when($selectedPackage, fn($q) => $q->where('package_id', $selectedPackage))->withCount('manifests')->get();

        return view('admin.manifests.index', compact('manifests', 'packages', 'selectedPackage', 'rooms'));
    }

    public function update(Request $request, Manifest $manifest)
    {
        $validated = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'family_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:M,F',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'passport_number' => 'nullable|string|max:50',
            'date_of_issue' => 'nullable|date',
            'date_of_expiry' => 'nullable|date',
            'issuing_office' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'marital_status' => 'nullable|string|max:50',
        ]);

        $manifest->update($validated);

        return back()->with('success', 'Biodata Jamaah berhasil diperbarui.');
    }

    public function toggleDocumentStatus(Request $request, Manifest $manifest)
    {
        $document = $request->document;
        $column = 'doc_' . $document . '_ok';
        if (!in_array($column, ['doc_passport_ok', 'doc_photo_ok', 'doc_nik_ok', 'doc_buku_nikah_ok'])) {
            return response()->json(['error' => 'Invalid document type'], 400);
        }

        $manifest->update([$column => !$manifest->$column]);

        return response()->json([
            'success' => true,
            'status' => $manifest->$column,
            'message' => 'Status ' . ucfirst($document) . ' diperbarui.'
        ]);
    }

    public function uploadScan(Request $request, Manifest $manifest)
    {
        $request->validate([
            'document_type' => 'required|in:passport,photo,nik,buku_nikah',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $type = $request->document_type;
        $column = $type . '_scan';
        
        // Delete old file if exists
        if ($manifest->$column) {
            Storage::disk('public')->delete($manifest->$column);
        }

        $path = $request->file('file')->store('manifests/scans', 'public');
        $manifest->update([$column => $path]);

        return back()->with('success', 'Dokumen ' . ucfirst($type) . ' berhasil diunggah.');
    }

    public function downloadBatchScans(Package $package)
    {
        $manifests = Manifest::whereHas('order', function($q) use ($package) {
            $q->where('package_id', $package->id);
        })->get();

        $zipFileName = 'docs_' . str_replace(' ', '_', $package->name) . '_' . date('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        if (!isset($manifests) || $manifests->isEmpty()) {
            return back()->with('error', 'Tidak ada jamaah di paket ini.');
        }

        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($manifests as $m) {
                $pilgrimFolder = str_replace(' ', '_', $m->full_name ?? 'Jamaah_' . $m->id);
                
                $docs = [
                    'passport' => $m->passport_scan,
                    'photo' => $m->photo_scan,
                    'nik' => $m->nik_scan,
                    'buku_nikah' => $m->buku_nikah_scan,
                ];

                foreach ($docs as $key => $path) {
                    if ($path && Storage::disk('public')->exists($path)) {
                        $fullPath = Storage::disk('public')->path($path);
                        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                        $zip->addFile($fullPath, $pilgrimFolder . '/' . $key . '.' . $extension);
                    }
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function transferRoom(Request $request, Manifest $manifest)
    {
        $request->validate([
            'room_list_id' => 'nullable|exists:room_lists,id'
        ]);

        if ($request->filled('room_list_id')) {
            $room = RoomList::withCount('manifests')->findOrFail($request->room_list_id);
            $max_capacity = match($room->room_type) {
                'Quad' => 4,
                'Triple' => 3,
                'Double' => 2,
                'Single' => 1,
                default => 2
            };

            if ($manifest->room_list_id != $room->id && $room->manifests_count >= $max_capacity) {
                return response()->json([
                    'success' => false,
                    'message' => "Kamar {$room->hotel_name} Tipe {$room->room_type} sudah penuh! (Maks: {$max_capacity})"
                ], 422);
            }
        }

        $manifest->update(['room_list_id' => $request->room_list_id]);

        return response()->json(['success' => true]);
    }

    public function storeRoomList(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'hotel_name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'room_type' => 'required|in:Quad,Triple,Double,Single'
        ]);

        RoomList::create($validated);
        return back()->with('success', 'Kamar berhasil ditambahkan ke Room List.');
    }

    public function plotRoom(Request $request, Manifest $manifest)
    {
        $request->validate(['room_list_id' => 'nullable|exists:room_lists,id']);
        
        if ($request->filled('room_list_id')) {
            $room = RoomList::withCount('manifests')->findOrFail($request->room_list_id);
            $max_capacity = match($room->room_type) {
                'Quad' => 4,
                'Triple' => 3,
                'Double' => 2,
                'Single' => 1,
                default => 2
            };

            // Calculate if there's space, but only if they're moving to a NEW room. 
            // If they are already in this room, it's fine.
            if ($manifest->room_list_id != $room->id && $room->manifests_count >= $max_capacity) {
                return back()->withErrors(['room_list_id' => "Kamar {$room->hotel_name} Tipe {$room->room_type} sudah penuh! (Maks: {$max_capacity})"]);
            }
            
            $manifest->update(['room_list_id' => $room->id]);
            return back()->with('success', 'Jamaah berhasil di-plot ke kamar.');
        }

        // Unplot
        $manifest->update(['room_list_id' => null]);
        return back()->with('success', 'Plotting kamar dihapus.');
    }

    public function plotBus(Request $request, Manifest $manifest)
    {
        $validated = $request->validate([
            'bus_number' => 'nullable|string|max:50',
            'seat_number' => 'nullable|string|max:50'
        ]);

        if (empty($validated['bus_number']) && empty($validated['seat_number'])) {
            $manifest->busSeater()->delete();
        } else {
            $manifest->busSeater()->updateOrCreate(
                ['manifest_id' => $manifest->id],
                $validated
            );
        }

        return back()->with('success', 'Kursi Bus berhasil diatur.');
    }

    public function updateEquipment(Request $request, Manifest $manifest)
    {
        $manifest->update([
            'eq_koper' => $request->has('eq_koper'),
            'eq_ihram_mukena' => $request->has('eq_ihram_mukena'),
            'eq_seragam_batik' => $request->has('eq_seragam_batik'),
            'eq_buku_panduan' => $request->has('eq_buku_panduan'),
        ]);

        return back()->with('success', 'Pembagian perlengkapan untuk ' . ($manifest->full_name ?? 'Jamaah') . ' berhasil diupdate.');
    }

    public function exportCsv(Request $request)
    {
        $query = Manifest::with(['order.package', 'order.lead'])->latest();
        if ($request->has('package_id') && $request->package_id != '') {
            $query->whereHas('order', fn($q) => $q->where('package_id', $request->package_id));
        }
        $manifests = $query->get();
        $filename = "data_paspor_wifa_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        // Format CSV Exact as requested: full_name, family_name, gender, place_of_birth, date_of_birth, passport_number, date_of_issue, date_of_expiry, issuing_office, nik, phone_number
        $columns = ['Full Name', 'Family Name', 'Gender', 'Place of Birth', 'Date of Birth', 'Passport Number', 'Date of Issue', 'Date of Expiry', 'Issuing Office', 'NIK', 'Phone Number'];

        return response()->stream(function() use($manifests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($manifests as $m) {
                fputcsv($file, [
                    $m->full_name, $m->family_name, $m->gender, $m->place_of_birth, 
                    $m->date_of_birth, $m->passport_number, $m->date_of_issue, 
                    $m->date_of_expiry, $m->issuing_office, $m->nik, $m->phone_number
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    public function exportRoomListCsv(Request $request)
    {
        $rooms = RoomList::with(['manifests', 'package'])
            ->when($request->package_id, fn($query) => $query->where('package_id', $request->package_id))
            ->get();
            
        $filename = "room_list_wifa_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        return response()->stream(function() use($rooms) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Paket', 'Hotel', 'Tipe Kamar', 'Nomor Kamar', 'Peserta 1', 'Peserta 2', 'Peserta 3', 'Peserta 4']);
            foreach ($rooms as $r) {
                $m = $r->manifests;
                fputcsv($file, [
                    $r->package->name ?? '-',
                    $r->hotel_name,
                    $r->room_type,
                    $r->room_number ?? '-',
                    $m->get(0)?->full_name ?? '-',
                    $m->get(1)?->full_name ?? '-',
                    $m->get(2)?->full_name ?? '-',
                    $m->get(3)?->full_name ?? '-',
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    public function exportBusSeaterCsv(Request $request)
    {
        $manifests = Manifest::with(['busSeater', 'order.package'])
            ->whereHas('busSeater')
            ->when($request->package_id, fn($query) => $query->whereHas('order', fn($q) => $q->where('package_id', $request->package_id)))
            ->get()
            ->sortBy(function($m) { return $m->busSeater->bus_number . '-' . $m->busSeater->seat_number; });
            
        $filename = "bus_seating_wifa_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        return response()->stream(function() use($manifests) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Paket', 'Nomor Bus', 'Nomor Kursi', 'Nama Jamaah', 'Jenis Kelamin', 'Telepon']);
            foreach ($manifests as $m) {
                fputcsv($file, [
                    $m->order->package->name ?? '-',
                    $m->busSeater->bus_number ?? '-',
                    $m->busSeater->seat_number ?? '-',
                    $m->full_name ?? '-',
                    $m->gender === 'M' ? 'L' : ($m->gender === 'F' ? 'P' : '-'),
                    $m->phone_number ?? '-'
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Manifest::with(['order.package', 'order.lead'])->latest();
        if ($request->has('package_id') && $request->package_id != '') {
            $query->whereHas('order', fn($q) => $q->where('package_id', $request->package_id));
        }
        $manifests = $query->get();
        $pdf = Pdf::loadView('admin.manifests.pdf', compact('manifests'))->setPaper('a4', 'landscape');
        return $pdf->download("manifest_wifa_" . date('Y-m-d_H-i-s') . ".pdf");
    }
}