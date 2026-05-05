<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Lead;
use App\Models\Manifest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index()
    {
        $user  = auth()->user();
        $query = Order::with(['lead', 'package', 'user']);

        // Partner only sees their own orders
        if ($user->isAgentOrPartner()) {
            $query->where('user_id', $user->id);
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        $leads    = Lead::orderBy('name')->get();
        return view('admin.orders.create', compact('packages', 'leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'     => 'required|exists:packages,id',
            'lead_id'        => 'nullable|exists:leads,id',
            'customer_name'  => 'required_without:lead_id|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'total_amount'   => 'required|numeric|min:0',
            'payment_status' => 'required|in:unpaid,partial,paid'
        ]);

        try {
            $this->orderService->createOrder($validated, auth()->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $message = auth()->user()->isAgentOrPartner() ? 'Pesanan berhasil ditambahkan.' : 'Data Pemesanan berhasil ditambahkan.';
        return redirect()->route('admin.orders.index')->with('success', $message);
    }

    public function edit(Order $order)
    {
        $this->authorizeOwnership($order);
        $packages = Package::where('is_active', true)->get();
        $leads    = Lead::orderBy('name')->get();
        return view('admin.orders.edit', compact('order', 'packages', 'leads'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorizeOwnership($order);

        $validated = $request->validate([
            'package_id'     => 'required|exists:packages,id',
            'lead_id'        => 'nullable|exists:leads,id',
            'customer_name'  => 'required_without:lead_id|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'total_amount'   => 'required|numeric|min:0',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Data Pemesanan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeOwnership($order);

        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,partial,paid'
        ]);

        $order->update($validated);
        return back()->with('success', 'Status Order berhasil diperbarui.');
    }

    public function exportInvoice(Order $order)
    {
        $this->authorizeOwnership($order);
        $order->load(['lead', 'package']);
        $pdf = Pdf::loadView('admin.orders.invoice', compact('order'));
        return $pdf->stream('Invoice_WifaTour_' . $order->order_number . '.pdf');
    }

    private function authorizeOwnership(Order $order): void
    {
        $user = auth()->user();
        if ($user->isAgentOrPartner() && $order->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke order ini.');
        }
    }
}
