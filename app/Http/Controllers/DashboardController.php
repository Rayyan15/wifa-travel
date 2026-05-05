<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Manifest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ── Agen Dashboard ─────────────────────────────────────────────────
        if ($user->role === 'agen') {
            return $this->agentDashboard($user);
        }

        // ── Partner Dashboard ──────────────────────────────────────────────
        if ($user->role === 'partner') {
            return $this->partnerDashboard($user);
        }

        // ── Superadmin / Sales Dashboard ───────────────────────────────────
        return $this->adminDashboard();
    }

    // ── AGEN ──────────────────────────────────────────────────────────────
    private function agentDashboard($user)
    {
        $myLeads = Lead::with('package')->where('user_id', $user->id)->latest()->get();

        $totalLeads   = $myLeads->count();
        $pendingLeads = $myLeads->where('status', 'pending')->count();
        $orderedLeads = $myLeads->whereIn('status', ['ordered', 'lunas'])->count();

        // Commission based on leads that became 'lunas'
        $lunasLeads          = $myLeads->where('status', 'lunas');
        $totalSalesValue     = $lunasLeads->sum(fn($l) => $l->package->price ?? 0);
        $estimatedCommission = $totalSalesValue * ($user->commission_rate / 100);

        $statusData = [
            'pending'   => $myLeads->where('status', 'pending')->count(),
            'contacted' => $myLeads->where('status', 'contacted')->count(),
            'closed'    => $myLeads->where('status', 'closed')->count(),
            'ordered'   => $myLeads->where('status', 'ordered')->count(),
            'lunas'     => $myLeads->where('status', 'lunas')->count(),
        ];

        $recentLeads = $myLeads->take(8);

        return view('admin.dashboard_agent', compact(
            'user', 'totalLeads', 'pendingLeads', 'orderedLeads',
            'totalSalesValue', 'estimatedCommission', 'statusData', 'recentLeads'
        ));
    }

    // ── PARTNER ──────────────────────────────────────────────────────────
    private function partnerDashboard($user)
    {
        $myLeads  = Lead::with('package')->where('user_id', $user->id)->latest()->get();
        $myOrders = Order::with(['lead', 'package'])->where('user_id', $user->id)->latest()->get();

        $totalLeads   = $myLeads->count();
        $totalOrders  = $myOrders->count();
        $paidOrders   = $myOrders->where('payment_status', 'paid')->count();
        $totalRevenue = $myOrders->sum('total_amount');

        $paidRevenue         = $myOrders->where('payment_status', 'paid')->sum('total_amount');
        $estimatedCommission = $paidRevenue * ($user->commission_rate / 100);

        $statusData = [
            'pending'   => $myLeads->where('status', 'pending')->count(),
            'contacted' => $myLeads->where('status', 'contacted')->count(),
            'closed'    => $myLeads->where('status', 'closed')->count(),
            'ordered'   => $myLeads->where('status', 'ordered')->count(),
            'lunas'     => $myLeads->where('status', 'lunas')->count(),
        ];

        $recentOrders = $myOrders->take(8);
        $recentLeads  = $myLeads->take(5);

        return view('admin.dashboard_partner', compact(
            'user', 'totalLeads', 'totalOrders', 'paidOrders',
            'totalRevenue', 'estimatedCommission', 'paidRevenue',
            'statusData', 'recentOrders', 'recentLeads'
        ));
    }

    // ── SUPERADMIN / SALES ────────────────────────────────────────────────
    private function adminDashboard()
    {
        $totalPackages = Package::count();
        $totalLeads    = Lead::count();
        $totalOrders   = Order::count();
        $paidOrders    = Order::where('payment_status', 'paid')->count();

        $leadStatusesRaw = Lead::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $leadStatuses = [
            'pending'   => $leadStatusesRaw['pending']   ?? 0,
            'contacted' => $leadStatusesRaw['contacted'] ?? 0,
            'closed'    => $leadStatusesRaw['closed']    ?? 0,
            'ordered'   => $leadStatusesRaw['ordered']   ?? 0,
            'lunas'     => $leadStatusesRaw['lunas']     ?? 0,
        ];

        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $leadsTrend  = [];
        $ordersTrend = [];
        foreach ($dates as $date) {
            $leadsTrend[]  = Lead::whereDate('created_at', $date)->count();
            $ordersTrend[] = Order::whereDate('created_at', $date)->count();
        }

        $trendLabels    = $dates->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
        $conversionRate = $totalLeads > 0 ? round(($totalOrders / $totalLeads) * 100, 1) : 0;

        return view('admin.dashboard', compact(
            'totalPackages', 'totalLeads', 'totalOrders', 'paidOrders',
            'leadStatuses', 'trendLabels', 'leadsTrend', 'ordersTrend', 'conversionRate'
        ));
    }
}
