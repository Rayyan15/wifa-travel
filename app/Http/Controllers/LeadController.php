<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\LeadExportService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected $leadExportService;

    public function __construct(LeadExportService $leadExportService)
    {
        $this->leadExportService = $leadExportService;
    }
    public function index()
    {
        $user = auth()->user();
        $packages = \App\Models\Package::where('is_active', true)->get();

        // Agen & partner only see their own leads
        $query = Lead::with(['package', 'user']);
        if ($user->isAgentOrPartner()) {
            $query->where('user_id', $user->id);
        }

        $leads = $query->latest()->paginate(15);

        return view('admin.leads.index', compact('leads', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'whatsapp'   => 'required|string|max:20',
            'package_id' => 'required|exists:packages,id',
            'status'     => 'required|in:pending,contacted,closed,ordered,lunas'
        ]);

        // Auto-assign to logged-in agen/partner
        $validated['user_id'] = auth()->id();

        Lead::create($validated);
        return back()->with('success', 'Lead baru berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $this->authorizeOwnership($lead);

        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,closed,ordered,lunas'
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($lead, $validated) {
            $lead->update($validated);
        });

        return back()->with('success', 'Status lead berhasil diperbarui.');
    }

    public function exportCsv()
    {
        $user  = auth()->user();
        $query = Lead::with(['package', 'user'])->latest();

        if ($user->isAgentOrPartner()) {
            $query->where('user_id', $user->id);
        }

        $leads = $query->get();
        return $this->leadExportService->exportCsv($leads);
    }

    /** Ensure agen/partner can only touch their own leads */
    private function authorizeOwnership(Lead $lead): void
    {
        $user = auth()->user();
        if ($user->isAgentOrPartner() && $lead->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke lead ini.');
        }
    }
}
