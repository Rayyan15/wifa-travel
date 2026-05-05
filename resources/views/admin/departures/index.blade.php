@extends('layouts.admin')
@section('title', 'Data Operasional Pemberangkatan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Operasional & Kloter</h2>
    <p class="text-gray-500 text-sm">Monitor seluruh status keberangkatan jamaah Wifa Tour.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($packages as $package)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
        <div class="p-5 border-b border-gray-50 bg-gray-50/50">
            <div class="flex justify-between items-start mb-2">
                <span class="bg-wifa-green/10 text-wifa-green text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider border border-wifa-green/20">{{ $package->type }}</span>
                <span class="text-gray-400 text-xs font-medium">{{ \Carbon\Carbon::parse($package->departure_date)->format('d M Y') }}</span>
            </div>
            <h3 class="font-bold text-gray-800 text-lg leading-tight">{{ $package->name }}</h3>
        </div>
        
        <div class="p-5 flex-1 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-100">
                    <div class="text-[10px] text-blue-600 font-bold uppercase mb-1">Total Seats</div>
                    <div class="text-xl font-black text-blue-900">{{ $package->total_seats }}</div>
                </div>
                <div class="bg-orange-50/50 p-3 rounded-xl border border-orange-100">
                    <div class="text-[10px] text-orange-600 font-bold uppercase mb-1">Sisa Kuota</div>
                    <div class="text-xl font-black text-orange-900">{{ $package->remaining_seats }}</div>
                </div>
            </div>

            <!-- Stats Bar Placeholder -->
            <div class="pt-2">
                <div class="flex justify-between text-xs font-semibold mb-1.5">
                    <span class="text-gray-500">Kesiapan Dokumen</span>
                    <span class="text-wifa-green">Monitor Detail →</span>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-wifa-green to-green-400 h-full w-0"></div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('admin.departures.show', $package->id) }}" class="block w-full text-center bg-wifa-green text-wifa-gold py-2.5 rounded-xl font-bold shadow-sm hover:bg-green-800 transition">
                Kontrol Operasional
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Paket Aktif</h3>
        <p class="text-gray-500 mb-8">Silakan buat paket perjalanan terlebih dahulu di menu "Paket" untuk memonitor operasional.</p>
        <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center px-6 py-3 bg-wifa-green text-wifa-gold rounded-full font-bold shadow-lg hover:bg-green-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Paket Pertama
        </a>
    </div>
    @endforelse
</div>
@endsection
