<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $sortOrder = Gallery::max('sort_order') ?? 0;

        foreach ($request->file('images') as $image) {
            $sortOrder++;
            $path = $image->store('galleries', 'public');

            Gallery::create([
                'title' => $request->title,
                'caption' => $request->caption,
                'image_path' => $path,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]);
        }

        $count = count($request->file('images'));
        return redirect()->route('admin.galleries.index')
            ->with('success', "{$count} foto berhasil diupload ke galeri.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $gallery->update([
            'title' => $request->title,
            'caption' => $request->caption,
            'sort_order' => $request->sort_order ?? $gallery->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete the file from storage
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
