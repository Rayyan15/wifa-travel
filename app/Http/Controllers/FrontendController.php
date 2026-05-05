<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Lead;
use App\Models\Gallery;

class FrontendController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)
            ->where('departure_date', '>=', now()->toDateString())
            ->orderBy('departure_date', 'asc')
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $testimonials = \App\Models\Testimonial::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();
            
        return view('frontend.home', compact('packages', 'galleries', 'testimonials'));
    }

    public function storeLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'package_id' => 'required|exists:packages,id'
        ]);

        // Automatically assign status
        $validated['status'] = 'pending';
        // Add note indicating it came from the website
        $validated['notes'] = 'Pendaftaran otomatis dari Landing Page Web.';
        
        Lead::create($validated);

        return redirect()->route('home')->with('success', 'Terima kasih! Tim kami akan segera merespons pendaftaran Anda melalui WhatsApp untuk proses selanjutnya.');
    }
}
