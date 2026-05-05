@extends('layouts.admin')
@section('title', 'Manajemen Transaksi (Orders)')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Transaksi Orders</h2>
    <a href="{{ route('admin.orders.create') }}" class="bg-wifa-green text-wifa-gold px-4 py-2 rounded-lg shadow font-medium hover:bg-green-800 transition flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pemesanan
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-bold">Kode Order</th>
                    <th class="py-4 px-6 font-bold">Pemesan (Lead)</th>
                    <th class="py-4 px-6 font-bold">Package</th>
                    <th class="py-4 px-6 font-bold">Harga</th>
                    <th class="py-4 px-6 font-bold">Status Bayar</th>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales')
                        <th class="py-4 px-6 font-bold">Pemilik / Partner</th>
                    @endif
                    <th class="py-4 px-6 font-bold">Tanggal</th>
                    <th class="py-4 px-6 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-6 font-mono font-bold text-wifa-green">{{ $order->order_code }}</td>
                    <td class="py-4 px-6">
                        <div class="font-medium">
                            @if($order->lead)
                                {{ $order->lead->name }}
                            @elseif($order->customer_name)
                                {{ $order->customer_name }}
                            @else
                                <span class="text-gray-400 italic">User Dihapus</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">
                            @if($order->lead)
                                {{ $order->lead->whatsapp ?? '-' }}
                            @elseif($order->customer_phone)
                                {{ $order->customer_phone }}
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-6">{{ $order->package->name ?? '-' }}</td>
                    <td class="py-4 px-6 font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="py-4 px-6">
                        @if($order->payment_status === 'paid')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">LUNAS</span>
                        @elseif($order->payment_status === 'partial')
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">DP/PARTIAL</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">PENDING</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales')
                    <td class="py-4 px-6">
                        @if($order->user_id)
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $order->user->role === 'partner' ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }} uppercase tracking-wider">
                                {{ $order->user->name }} ({{ ucfirst($order->user->role) }})
                            </span>
                        @else
                            <span class="text-xs text-gray-400 italic">-</span>
                        @endif
                    </td>
                    @endif
                    <td class="py-4 px-6 text-gray-500">{{ $order->created_at->format('d M Y - H:i') }}</td>
                    <td class="py-4 px-6 text-right space-x-2">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.orders.edit', $order) }}" class="w-8 h-8 rounded bg-gray-50 text-blue-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition" title="Edit Order">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            @if($order->payment_status === 'paid')
                                <a href="{{ route('admin.orders.export-invoice', $order) }}" target="_blank" class="w-8 h-8 rounded bg-gray-50 text-indigo-500 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center transition" title="Cetak Kwitansi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>
                            @endif
                            @if($order->payment_status !== 'paid')
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('POST')
                                    <select name="payment_status" onchange="this.form.submit()" class="text-xs font-bold rounded-md border-gray-300 py-1 pl-2 pr-6 focus:border-wifa-gold focus:ring-wifa-gold bg-white shadow-sm">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>PENDING</option>
                                        <option value="partial" {{ $order->payment_status === 'partial' ? 'selected' : '' }}>DP / PARTIAL</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>LUNAS</option>
                                    </select>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">Selesai</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ (auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales') ? 8 : 7 }}" class="py-8 text-center text-gray-400 font-medium">Belum ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $orders->links('pagination::tailwind') }}</div>
@endsection
