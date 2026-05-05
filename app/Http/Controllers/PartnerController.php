<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Package;

class PartnerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $myLeads  = Lead::where('user_id', $user->id)->latest()->get();
        $myOrders = Order::with(['lead', 'package'])->where('user_id', $user->id)->latest()->get();

        $totalLeads   = $myLeads->count();
        $totalOrders  = $myOrders->count();
        $paidOrders   = $myOrders->where('payment_status', 'paid')->count();
        $totalRevenue = $myOrders->sum('total_amount');

        // Commission on paid orders
        $paidRevenue         = $myOrders->where('payment_status', 'paid')->sum('total_amount');
        $estimatedCommission = $paidRevenue * ($user->commission_rate / 100);

        $packages    = Package::where('is_active', true)->get();
        $recentLeads = $myLeads->take(5);

        $statusData = [
            'pending'   => $myLeads->where('status', 'pending')->count(),
            'contacted' => $myLeads->where('status', 'contacted')->count(),
            'closed'    => $myLeads->where('status', 'closed')->count(),
            'ordered'   => $myLeads->where('status', 'ordered')->count(),
            'lunas'     => $myLeads->where('status', 'lunas')->count(),
        ];

        return view('partner.dashboard', compact(
            'totalLeads', 'totalOrders', 'paidOrders', 'totalRevenue',
            'estimatedCommission', 'paidRevenue', 'user',
            'myOrders', 'recentLeads', 'statusData', 'packages'
        ));
    }

    public function orders()
    {
        $user     = auth()->user();
        $orders   = Order::with(['lead', 'package'])->where('user_id', $user->id)->latest()->paginate(15);
        $packages = Package::where('is_active', true)->get();
        $leads    = Lead::where('user_id', $user->id)->orderBy('name')->get();
        return view('partner.orders', compact('orders', 'packages', 'leads'));
    }

    public function leads()
    {
        $user     = auth()->user();
        $leads    = Lead::with('package')->where('user_id', $user->id)->latest()->paginate(15);
        $packages = Package::where('is_active', true)->get();
        return view('partner.leads', compact('leads', 'packages'));
    }
}
