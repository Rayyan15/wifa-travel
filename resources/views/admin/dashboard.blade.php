@extends('layouts.admin')
@section('title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Card: Total Packages -->
    <div class="bg-gradient-to-br from-wifa-green to-[#0f2c1f] rounded-[1.5rem] shadow-lg border border-[#2b5945] p-6 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute right-0 top-0 w-24 h-24 bg-white/5 rounded-full blur-xl -translate-y-4 translate-x-4"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <p class="text-sm font-semibold text-wifa-gold uppercase tracking-wider">Total Paket Aktif</p>
            <div class="p-2 bg-white/10 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>
        <h3 class="text-4xl font-black relative z-10">{{ $totalPackages }}</h3>
    </div>

    <!-- Card: Total Leads -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition hover:shadow-md">
        <div class="flex justify-between items-start mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Prospek (Leads)</p>
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $totalLeads }}</h3>
    </div>

    <!-- Card: Total Orders -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition hover:shadow-md">
        <div class="flex justify-between items-start mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pesanan</p>
            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="flex items-end gap-2">
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</h3>
        </div>
    </div>

    <!-- Card: Conversion Rate -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition hover:shadow-md">
        <div class="flex justify-between items-start mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Conversion Rate</p>
            <div class="p-2 bg-orange-50 rounded-lg text-orange-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        <div class="flex items-end gap-2">
            <h3 class="text-3xl font-bold text-gray-800">{{ $conversionRate }}%</h3>
            <span class="text-xs text-green-500 font-medium mb-1">vs Leads</span>
        </div>
    </div>

    <!-- Card: Paid Orders -->
    <div class="bg-gradient-to-br from-wifa-gold to-yellow-600 rounded-[1.5rem] shadow-lg border border-yellow-500 p-6 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/20 rounded-full blur-xl"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <p class="text-xs font-bold text-yellow-100 uppercase tracking-wider">Pesanan Lunas</p>
            <div class="p-2 bg-white/20 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <h3 class="text-4xl font-black relative z-10">{{ $paidOrders }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Tren Pendaftaran (7 Hari Terakhir)</h3>
            <span class="text-xs font-medium bg-gray-100 text-gray-600 px-3 py-1 rounded-full">Performa Mingguan</span>
        </div>
        <div class="w-full h-72 flex justify-center">
            <canvas id="trendChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Status Prospek</h3>
        </div>
        <div class="w-full h-64 flex justify-center">
            <canvas id="leadStatusChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const leadCtx = document.getElementById('leadStatusChart').getContext('2d');
    new Chart(leadCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Contacted', 'Closed', 'Ordered', 'Lunas'],
            datasets: [{
                data: [{{ $leadStatuses['pending'] }}, {{ $leadStatuses['contacted'] }}, {{ $leadStatuses['closed'] }}, {{ $leadStatuses['ordered'] }}, {{ $leadStatuses['lunas'] }}],
                backgroundColor: ['#EAB308', '#3B82F6', '#6B7280', '#10B981', '#1B4332'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [
                {
                    label: 'Leads',
                    data: {!! json_encode($leadsTrend) !!},
                    borderColor: '#D4AF37',
                    backgroundColor: 'rgba(212, 175, 55, 0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Orders',
                    data: {!! json_encode($ordersTrend) !!},
                    borderColor: '#1B4332',
                    backgroundColor: 'rgba(27, 67, 50, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
