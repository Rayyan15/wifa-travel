<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Package;

class AgentController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $myLeads       = Lead::where('user_id', $user->id)->latest()->get();
        $totalLeads    = $myLeads->count();
        $pendingLeads  = $myLeads->where('status', 'pending')->count();
        $closedLeads   = $myLeads->where('status', 'closed')->count();
        $orderedLeads  = $myLeads->whereIn('status', ['ordered', 'lunas'])->count();

        // Commission: based on leads that became orders (lunas)
        $commissionLeads = $myLeads->where('status', 'lunas');
        $totalSalesValue = 0;
        foreach ($commissionLeads as $lead) {
            $totalSalesValue += $lead->package->price ?? 0;
        }
        $estimatedCommission = $totalSalesValue * ($user->commission_rate / 100);

        $packages = Package::where('is_active', true)->get();

        // Status breakdown for chart
        $statusData = [
            'pending'   => $myLeads->where('status', 'pending')->count(),
            'contacted' => $myLeads->where('status', 'contacted')->count(),
            'closed'    => $myLeads->where('status', 'closed')->count(),
            'ordered'   => $myLeads->where('status', 'ordered')->count(),
            'lunas'     => $myLeads->where('status', 'lunas')->count(),
        ];

        $recentLeads = $myLeads->take(10);

        return view('agent.dashboard', compact(
            'totalLeads', 'pendingLeads', 'closedLeads', 'orderedLeads',
            'estimatedCommission', 'totalSalesValue', 'user',
            'statusData', 'recentLeads', 'packages'
        ));
    }
}
