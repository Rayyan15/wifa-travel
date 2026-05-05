@extends('layouts.admin')
@section('title', 'Dashboard Agen')

@section('content')
{{-- ═══ GREETING ═══ --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h2>
    <p class="text-gray-500 text-sm mt-1">Ini adalah ringkasan performa & komisi Anda.</p>
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

    {{-- Pending --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menunggu</span>
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $pendingLeads }}</div>
    </div>

    {{-- Ordered/Lunas --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Berhasil Closing</span>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $orderedLeads }}</div>
    </div>

    {{-- Komisi --}}
    <div class="bg-gradient-to-br from-wifa-green to-[#143325] rounded-2xl p-5 shadow-sm text-white">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-white/60 uppercase tracking-wider">Estimasi Komisi</span>
            <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-wifa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold text-wifa-gold">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</div>
        <div class="text-xs text-white/50 mt-1">Rate: {{ $user->commission_rate }}% dari nilai lunas</div>
    </div>
</div>

{{-- ═══ SALES VALUE + STATUS CHART ═══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Status Chart --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Status Leads Saya</h3>
        <canvas id="statusChart" height="220"></canvas>
    </div>

    {{-- Summary Card --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-700">Ringkasan Performa</h3>
            <a href="{{ route('admin.leads.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">Lihat semua →</a>
        </div>
        <div class="space-y-3 mb-5">
            @php
                $bars = [
                    ['label'=>'Pending',   'val'=>$statusData['pending'],   'color'=>'bg-amber-400',   'total'=>max($totalLeads,1)],
                    ['label'=>'Contacted', 'val'=>$statusData['contacted'], 'color'=>'bg-blue-400',    'total'=>max($totalLeads,1)],
                    ['label'=>'Ordered',   'val'=>$statusData['ordered'],   'color'=>'bg-violet-400',  'total'=>max($totalLeads,1)],
                    ['label'=>'Lunas',     'val'=>$statusData['lunas'],     'color'=>'bg-emerald-500', 'total'=>max($totalLeads,1)],
                ];
            @endphp
            @foreach($bars as $bar)
            <div class="flex items-center gap-3">
                <div class="w-20 text-xs text-gray-500 font-medium">{{ $bar['label'] }}</div>
                <div class="flex-1 bg-gray-100 rounded-full h-2.5">
                    <div class="{{ $bar['color'] }} h-2.5 rounded-full transition-all" style="width:{{ $totalLeads > 0 ? round($bar['val']/$bar['total']*100) : 0 }}%"></div>
                </div>
                <div class="w-8 text-right text-xs font-bold text-gray-700">{{ $bar['val'] }}</div>
            </div>
            @endforeach
        </div>
        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
            <div>
                <div class="text-xs text-gray-400">Total Nilai Penjualan Lunas</div>
                <div class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalSalesValue, 0, ',', '.') }}</div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400">Komisi ({{ $user->commission_rate }}%)</div>
                <div class="text-xl font-bold text-wifa-green mt-1">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ RECENT LEADS TABLE ═══ --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Leads Terbaru</h3>
        <a href="{{ route('admin.leads.index') }}" class="px-4 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">+ Tambah Lead</a>
    </div>
    @if($recentLeads->isEmpty())
        <div class="py-12 text-center text-gray-400 text-sm">Belum ada leads. Mulai tambahkan leads pertama Anda!</div>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($recentLeads as $lead)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $lead->name }}</td>
                    <td class="px-6 py-3 text-gray-500">{{ $lead->package->name ?? '-' }}</td>
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending','Contacted','Closed','Ordered','Lunas'],
        datasets:[{ data: [{{ $statusData['pending'] }},{{ $statusData['contacted'] }},{{ $statusData['closed'] }},{{ $statusData['ordered'] }},{{ $statusData['lunas'] }}], backgroundColor:['#FCD34D','#60A5FA','#9CA3AF','#A78BFA','#34D399'], borderWidth:0, hoverOffset:4 }]
    },
    options: { cutout:'70%', plugins:{ legend:{ position:'bottom', labels:{ boxWidth:10, padding:12, font:{ size:11 } } } } }
});
</script>
@endsection
