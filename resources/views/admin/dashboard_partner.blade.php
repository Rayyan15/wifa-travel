@extends('layouts.admin')
@section('title', 'Dashboard Partner')

@section('content')
{{-- ═══ GREETING ═══ --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h2>
    <p class="text-gray-500 text-sm mt-1">Ringkasan performa dan pemesanan Anda sebagai Partner.</p>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Total Leads --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Leads</span>
            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $totalLeads }}</div>
    </div>

    {{-- Total Orders --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pesanan</span>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</div>
    </div>

    {{-- Pesanan Lunas --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pesanan Lunas</span>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $paidOrders }}</div>
    </div>

    {{-- Estimasi Komisi --}}
    <div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-2xl p-5 shadow-sm text-white">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-white/70 uppercase tracking-wider">Komisi Cair</span>
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</div>
        <div class="text-xs text-white/60 mt-1">Berdasarkan Total Lunas Rp {{ number_format($paidRevenue, 0, ',', '.') }}</div>
    </div>
</div>

{{-- ═══ CHARTS & REVENUE ═══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Status Chart --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Status Prospek (Leads)</h3>
        <canvas id="partnerStatusChart" height="220"></canvas>
    </div>

    {{-- Detail Revenue --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col justify-center">
        <h3 class="text-sm font-semibold text-gray-700 mb-6">Ringkasan Finansial</h3>
        
        <div class="grid grid-cols-2 gap-6">
            <div class="p-5 border border-gray-100 rounded-xl">
                <div class="text-xs font-medium text-gray-500 mb-1">Total Nilai Pemesanan</div>
                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            
            <div class="p-5 border border-emerald-100 bg-emerald-50 rounded-xl relative overflow-hidden">
                <div class="relative z-10">
                    <div class="text-xs font-medium text-emerald-800 mb-1">Detail Komisi ({{ $user->commission_rate }}%)</div>
                    <div class="text-2xl font-bold text-emerald-700">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</div>
                    <div class="text-xs text-emerald-600 mt-2">Hanya dihitung dari pesanan 'Paid' / Lunas.</div>
                </div>
                <svg class="absolute -bottom-4 -right-4 w-24 h-24 text-emerald-500 opacity-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- ═══ RECENT DATA TABS ═══ --}}
<div x-data="{ tab: 'orders' }" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <div class="flex gap-4">
            <button @click="tab = 'orders'" :class="{'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-4 -mb-4': tab === 'orders', 'text-gray-500 hover:text-gray-700 pb-4 -mb-4 font-medium': tab !== 'orders'}" class="text-sm transition">Pesanan Terbaru</button>
            <button @click="tab = 'leads'" :class="{'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-4 -mb-4': tab === 'leads', 'text-gray-500 hover:text-gray-700 pb-4 -mb-4 font-medium': tab !== 'leads'}" class="text-sm transition">Leads Terbaru</button>
        </div>
        <div>
            <a x-show="tab === 'orders'" href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-semibold transition">Lihat Semua Data Pemesanan</a>
            <a x-show="tab === 'leads'" href="{{ route('admin.leads.index') }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-semibold transition animate-fade-in" style="display:none;">Lihat Semua Leads</a>
        </div>
    </div>

    {{-- Tab Orders --}}
    <div x-show="tab === 'orders'" class="animate-fade-in">
        @if($recentOrders->isEmpty())
            <div class="py-12 text-center text-gray-400 text-sm">Belum ada pesanan terbaru.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Lead/Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Paket</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tipe Pembayaran</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-emerald-700">{{ $order->order_code }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $order->lead->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->package->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'unpaid' => 'bg-red-100 text-red-700',
                                    'partial' => 'bg-amber-100 text-amber-700',
                                    'paid' => 'bg-emerald-100 text-emerald-700',
                                ];
                                $label = match($order->payment_status) {
                                    'unpaid' => 'Belum Lunas',
                                    'partial'=> 'DP / Sebagian',
                                    'paid'   => 'Lunas',
                                    default  => ucfirst($order->payment_status),
                                };
                            @endphp
                            <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-full {{ $statusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Tab Leads --}}
    <div x-show="tab === 'leads'" class="animate-fade-in" style="display:none;">
        @if($recentLeads->isEmpty())
            <div class="py-12 text-center text-gray-400 text-sm">Belum ada leads.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Prospek</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nomor WA</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentLeads as $lead)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $lead->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $lead->whatsapp }}</td>
                        <td class="px-6 py-3">
                            @php
                                $sc = ['pending'=>'bg-amber-100 text-amber-700','contacted'=>'bg-blue-100 text-blue-700','closed'=>'bg-gray-100 text-gray-600','ordered'=>'bg-violet-100 text-violet-700','lunas'=>'bg-emerald-100 text-emerald-700'];
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $sc[$lead->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($lead->status) }}</span>
                        </td>
                        <td class="px-6 py-3 text-gray-400">{{ $lead->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('partnerStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending','Contacted','Closed','Ordered','Lunas'],
        datasets:[{ data: [{{ $statusData['pending'] }},{{ $statusData['contacted'] }},{{ $statusData['closed'] }},{{ $statusData['ordered'] }},{{ $statusData['lunas'] }}], backgroundColor:['#FCD34D','#60A5FA','#9CA3AF','#A78BFA','#34D399'], borderWidth:0, hoverOffset:4 }]
    },
    options: { cutout:'70%', plugins:{ legend:{ position:'bottom', labels:{ boxWidth:10, padding:12, font:{ size:11 } } } } }
});
</script>
<style>
    .animate-fade-in { animation: fadeIn .3s ease-in-out; }
    @keyframes fadeIn { from{opacity:0;} to{opacity:1;} }
</style>
@endsection
