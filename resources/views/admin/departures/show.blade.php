@extends('layouts.admin')
@section('title', 'Detail Kloter: ' . $package->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin.departures.index') }}" class="text-wifa-green font-bold text-sm flex items-center mb-1 hover:underline">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar Operasional
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Kloter: {{ $package->name }}</h2>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.manifests.index', ['package_id' => $package->id]) }}" class="bg-white text-gray-700 border border-gray-200 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm text-sm">
            Manajemen Manifest & Room
        </a>
        <a href="{{ route('admin.manifests.download-batch', $package->id) }}" class="bg-wifa-gold text-wifa-green px-5 py-2.5 rounded-xl font-bold hover:bg-yellow-500 transition shadow-sm text-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            ZIP All Documents
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <!-- Main Progress Card -->
    <div class="lg:col-span-1 bg-wifa-green text-wifa-gold rounded-2xl p-6 shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-sm font-bold uppercase tracking-widest opacity-80 mb-4">Total Kesiapan Dokumen</h3>
            <div class="text-6xl font-black mb-2">{{ $percentage }}%</div>
            <p class="text-[10px] leading-relaxed opacity-75">Dihitung berdasarkan kelengkapan Paspor, Foto, NIK untuk semua jamaah, dan Buku Nikah (jika status Nikah).</p>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-wifa-gold/10 rounded-full"></div>
    </div>

    <!-- Stats Breakdown -->
    <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <div class="text-xs text-gray-400 font-bold uppercase mb-2">Total Jamaah</div>
            <div class="text-3xl font-black text-gray-800">{{ $totalJamaah }}</div>
            <div class="text-[10px] text-gray-500 mt-1">Status: Siap Berangkat</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-blue-500">
            <div class="text-xs text-blue-500 font-bold uppercase mb-2">Paspor OK</div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['passport'] }}/{{ $totalJamaah }}</div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-3">
                <div class="bg-blue-500 h-full rounded-full" style="width: {{ $totalJamaah > 0 ? ($stats['passport']/$totalJamaah)*100 : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-purple-500">
            <div class="text-xs text-purple-500 font-bold uppercase mb-2">Foto OK</div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['photo'] }}/{{ $totalJamaah }}</div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-3">
                <div class="bg-purple-500 h-full rounded-full" style="width: {{ $totalJamaah > 0 ? ($stats['photo']/$totalJamaah)*100 : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-teal-500">
            <div class="text-xs text-teal-500 font-bold uppercase mb-2">NIK OK</div>
            <div class="text-3xl font-black text-gray-800">{{ $stats['nik'] }}/{{ $totalJamaah }}</div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-3">
                <div class="bg-teal-500 h-full rounded-full" style="width: {{ $totalJamaah > 0 ? ($stats['nik']/$totalJamaah)*100 : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Daftar Jamaah & Status Dokumen</h3>
        <div class="text-xs text-gray-500">Total: {{ $totalJamaah }} Jamaah</div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-100">
                    <th class="py-4 px-6 font-bold">Nama Jamaah</th>
                    <th class="py-4 px-6 font-bold">Status</th>
                    <th class="py-4 px-6 font-bold text-center">Paspor</th>
                    <th class="py-4 px-6 font-bold text-center">Foto</th>
                    <th class="py-4 px-6 font-bold text-center">NIK</th>
                    <th class="py-4 px-6 font-bold text-center">Buku Nikah</th>
                    <th class="py-4 px-6 font-bold text-right">Progress</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @foreach($manifests as $m)
                @php
                    $reqTotal = 3;
                    $done = 0;
                    if($m->doc_passport_ok) $done++;
                    if($m->doc_photo_ok) $done++;
                    if($m->doc_nik_ok) $done++;
                    
                    $isMarried = $m->marital_status === 'Nikah';
                    if($isMarried) {
                        $reqTotal++;
                        if($m->doc_buku_nikah_ok) $done++;
                    }
                    $p = round(($done/$reqTotal)*100);
                @endphp
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-800 leading-tight">{{ $m->full_name }}</div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $m->passport_number ?? 'No Passport' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded border {{ $isMarried ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                            {{ $m->marital_status ?? 'Lajang' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-3 h-3 rounded-full mx-auto {{ $m->doc_passport_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}"></div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-3 h-3 rounded-full mx-auto {{ $m->doc_photo_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}"></div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="w-3 h-3 rounded-full mx-auto {{ $m->doc_nik_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}"></div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($isMarried)
                            <div class="w-3 h-3 rounded-full mx-auto {{ $m->doc_buku_nikah_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}"></div>
                        @else
                            <span class="text-[10px] text-gray-300">-</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right font-bold {{ $p == 100 ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $p }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
