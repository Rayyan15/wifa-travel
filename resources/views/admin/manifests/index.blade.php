@extends('layouts.admin')
@section('title', 'Manajemen Manifest Jamaah')

@section('content')
<div class="mb-6 flex space-x-4 items-center">
    <h2 class="text-2xl font-bold text-gray-800">Manifest, Room List & Bus Seating</h2>
</div>

<!-- Filter Paket -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <form action="{{ route('admin.manifests.index') }}" method="GET" class="flex items-end space-x-4">
        <div class="flex-1 max-w-sm">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Berdasarkan Paket</label>
            <select name="package_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-wifa-green focus:border-wifa-green">
                <option value="">Semua Paket Perjalanan</option>
                @foreach($packages as $p)
                    <option value="{{ $p->id }}" {{ $selectedPackage == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ \Carbon\Carbon::parse($p->departure_date)->format('d M Y') }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-wifa-green text-wifa-gold px-6 py-2.5 rounded-lg shadow font-medium hover:bg-green-800 transition">Tampilkan</button>
    </form>
</div>

<div x-data="{ tab: 'passport' }" x-cloak>
    <!-- TAB NAVIGATION -->
    <div class="flex border-b border-gray-200 mb-6 bg-white rounded-t-xl pt-2 px-2 shadow-sm">
        <button @click="tab = 'passport'" :class="tab === 'passport' ? 'border-wifa-green text-wifa-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition focus:outline-none flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
            Data Paspor
        </button>
        <button @click="tab = 'room'" :class="tab === 'room' ? 'border-wifa-green text-wifa-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition focus:outline-none flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Room Menu
        </button>
        <button @click="tab = 'bus'" :class="tab === 'bus' ? 'border-wifa-green text-wifa-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition focus:outline-none flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Bus Seating
        </button>
        <button @click="tab = 'equipment'" :class="tab === 'equipment' ? 'border-wifa-green text-wifa-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition focus:outline-none flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Perlengkapan
        </button>
    </div>

    <!-- TAB 1: DATA PASPOR -->
    <div x-show="tab === 'passport'">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Daftar Manifest / Paspor</h3>
            <div>
                <a href="{{ route('admin.manifests.export-csv', ['package_id' => $selectedPackage]) }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg shadow font-medium hover:bg-gray-900 transition text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV Paspor (Standard)
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold">Nama Paspor</th>
                            <th class="py-4 px-6 font-bold">Dokumen (Click to Toggle)</th>
                            <th class="py-4 px-6 font-bold">Upload Scan</th>
                            <th class="py-4 px-6 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($manifests as $m)
                        @php
                            $isWarning = false;
                            $hasPassportDate = $m->date_of_expiry != null;
                            if ($hasPassportDate && $m->order && $m->order->package) {
                                $expiry = \Carbon\Carbon::parse($m->date_of_expiry);
                                $depart = \Carbon\Carbon::parse($m->order->package->departure_date);
                                // Warning if expiry is less than 6 months from departure
                                if ($expiry->copy()->subMonths(6)->lessThan($depart)) {
                                    $isWarning = true;
                                }
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition" x-data="{ showUpload: false }">
                            <td class="py-4 px-6">
                                @php
                                    $displayName = $m->full_name;
                                    $isNameFromPesan = false;
                                    if (!$displayName) {
                                        $displayName = $m->order?->lead?->name ?? $m->order?->customer_name;
                                        $isNameFromPesan = true;
                                    }
                                @endphp
                                <div class="font-bold text-gray-800">
                                    {{ $displayName ?? '-' }}
                                    @if($isNameFromPesan && $displayName)
                                        <span class="ml-1.5 text-[9px] font-bold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full uppercase tracking-wide">dari pemesan</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400">Paspor: {{ $m->full_name ? ($m->marital_status ?? 'Lajang') : '⚠ Belum diisi' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="flex flex-col items-center">
                                        <div id="doc-passport-{{ $m->id }}" @click="toggleDoc({{ $m->id }}, 'passport')" class="w-4 h-4 rounded-full cursor-pointer transition {{ $m->doc_passport_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}" title="Paspor"></div>
                                        <span class="text-[8px] mt-1 text-gray-400 uppercase font-black">PAS</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div id="doc-photo-{{ $m->id }}" @click="toggleDoc({{ $m->id }}, 'photo')" class="w-4 h-4 rounded-full cursor-pointer transition {{ $m->doc_photo_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}" title="Foto"></div>
                                        <span class="text-[8px] mt-1 text-gray-400 uppercase font-black">FOT</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div id="doc-nik-{{ $m->id }}" @click="toggleDoc({{ $m->id }}, 'nik')" class="w-4 h-4 rounded-full cursor-pointer transition {{ $m->doc_nik_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}" title="KTP/NIK"></div>
                                        <span class="text-[8px] mt-1 text-gray-400 uppercase font-black">NIK</span>
                                    </div>
                                    @if($m->marital_status === 'Nikah')
                                    <div class="flex flex-col items-center">
                                        <div id="doc-buku_nikah-{{ $m->id }}" @click="toggleDoc({{ $m->id }}, 'buku_nikah')" class="w-4 h-4 rounded-full cursor-pointer transition {{ $m->doc_buku_nikah_ok ? 'bg-green-500 shadow-sm shadow-green-200' : 'bg-red-500 shadow-sm shadow-red-200' }}" title="Buku Nikah"></div>
                                        <span class="text-[8px] mt-1 text-gray-400 uppercase font-black">BK.N</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1">
                                    <button @click="$dispatch('open-modal-upload-{{ $m->id }}', { type: 'passport' })" class="text-[10px] px-1.5 py-0.5 rounded {{ $m->passport_scan ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} hover:bg-wifa-gold hover:text-wifa-green transition">PAS</button>
                                    <button @click="$dispatch('open-modal-upload-{{ $m->id }}', { type: 'photo' })" class="text-[10px] px-1.5 py-0.5 rounded {{ $m->photo_scan ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} hover:bg-wifa-gold hover:text-wifa-green transition">FOT</button>
                                    <button @click="$dispatch('open-modal-upload-{{ $m->id }}', { type: 'nik' })" class="text-[10px] px-1.5 py-0.5 rounded {{ $m->nik_scan ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} hover:bg-wifa-gold hover:text-wifa-green transition">NIK</button>
                                    @if($m->marital_status === 'Nikah')
                                    <button @click="$dispatch('open-modal-upload-{{ $m->id }}', { type: 'buku_nikah' })" class="text-[10px] px-1.5 py-0.5 rounded {{ $m->buku_nikah_scan ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} hover:bg-wifa-gold hover:text-wifa-green transition">BK.N</button>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-1">
                                    <button type="button" @click="$dispatch('open-modal-edit-{{ $m->id }}')" class="text-indigo-600 hover:text-indigo-900 border border-indigo-200 bg-indigo-50 px-2.5 py-1 rounded text-xs font-bold">Edit</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Upload Scan (Per Manifest) -->
                        <div x-data="{ open: false, type: 'passport' }" 
                             @open-modal-upload-{{ $m->id }}.window="open = true; type = $event.detail.type" 
                             class="relative z-50" x-show="open" style="display: none;">
                            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="open = false"></div>
                            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                                <form action="{{ route('admin.manifests.upload-scan', $m->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden">
                                    @csrf
                                    <input type="hidden" name="document_type" :value="type">
                                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                        <h3 class="font-bold text-gray-800">Upload <span class="uppercase" x-text="type"></span> Scan</h3>
                                        <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                                    </div>
                                    <div class="p-6">
                                        <div class="mb-4">
                                            <p class="text-xs text-gray-500 mb-4">Unggah dokumen untuk <span class="font-bold text-gray-800">{{ $m->full_name }}</span>. Format: JPG, PNG, PDF (Max 2MB).</p>
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Pilih File</label>
                                            <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file" required>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                                        <button type="submit" class="bg-wifa-green text-wifa-gold px-4 py-2 font-bold rounded text-sm shadow-sm hover:bg-green-800 transition">Upload Dokumen</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Edit Data Paspor -->
                        <div x-data="{ open: false }" @open-modal-edit-{{ $m->id }}.window="open = true" class="relative z-50" x-show="open" style="display: none;">
                            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="open = false"></div>
                            <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                                <form action="{{ route('admin.manifests.update', $m->id) }}" method="POST" class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
                                    @csrf
                                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                        <h3 class="text-lg font-bold text-gray-800">Edit Data Paspor & Biodata</h3>
                                        <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                                    </div>
                                    <div class="p-6 overflow-y-auto w-full grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Full Name</label>
                                            <input type="text" name="full_name" value="{{ $m->full_name }}" class="w-full rounded border-gray-300 text-sm focus:ring-wifa-green">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Family Name</label>
                                            <input type="text" name="family_name" value="{{ $m->family_name }}" class="w-full rounded border-gray-300 text-sm focus:ring-wifa-green">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Gender (M/F)</label>
                                            <select name="gender" class="w-full rounded border-gray-300 text-sm">
                                                <option value="" {{ !$m->gender ? 'selected' : '' }}>Pilih</option>
                                                <option value="M" {{ $m->gender == 'M' ? 'selected' : '' }}>M (Laki-laki)</option>
                                                <option value="F" {{ $m->gender == 'F' ? 'selected' : '' }}>F (Perempuan)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Marital Status</label>
                                            <select name="marital_status" class="w-full rounded border-gray-300 text-sm">
                                                <option value="Lajang" {{ $m->marital_status == 'Lajang' ? 'selected' : '' }}>Lajang</option>
                                                <option value="Nikah" {{ $m->marital_status == 'Nikah' ? 'selected' : '' }}>Nikah</option>
                                                <option value="Cerai" {{ $m->marital_status == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                                                <option value="Janda/Duda" {{ $m->marital_status == 'Janda/Duda' ? 'selected' : '' }}>Janda/Duda</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Passpor Number</label>
                                            <input type="text" name="passport_number" value="{{ $m->passport_number }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Date of Issue</label>
                                            <input type="date" name="date_of_issue" value="{{ $m->date_of_issue }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Date of Expiry</label>
                                            <input type="date" name="date_of_expiry" value="{{ $m->date_of_expiry }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Place of Birth</label>
                                            <input type="text" name="place_of_birth" value="{{ $m->place_of_birth }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Date of Birth</label>
                                            <input type="date" name="date_of_birth" value="{{ $m->date_of_birth }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">NIK</label>
                                            <input type="text" name="nik" value="{{ $m->nik }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold mb-1">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{ $m->phone_number }}" class="w-full rounded border-gray-300 text-sm">
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                                        <button type="submit" class="bg-wifa-green text-wifa-gold px-4 py-2 font-bold rounded shadow-sm hover:bg-green-800">Simpan Detail</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="5" class="py-8 text-center text-gray-400 font-medium">Belum ada jamaah/manifest di paket ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">{{ $manifests->links('pagination::tailwind') }}</div>
        </div>
    </div>

    <!-- TAB 2: ROOM LIST (Draggable) -->
    <div x-show="tab === 'room'" style="display: none;">
        @if(!$selectedPackage)
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-5 py-4 rounded-xl shadow-sm text-center">
                Silakan filter/pilih **Paket Perjalanan** terlebih dahulu di atas untuk mengatur kamar jamaah.
            </div>
        @else
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Manajemen Kamar (Drag & Drop)</h3>
                    <p class="text-xs text-gray-500">Geser nama jamaah ke dalam kotak kamar untuk plotting.</p>
                </div>
                <div class="space-x-2">
                    <button x-data @click="$dispatch('open-modal-add-room')" class="bg-wifa-green text-wifa-gold px-4 py-2 rounded-lg shadow font-medium hover:bg-green-800 transition text-sm">
                        + Tambah Kamar Baru
                    </button>
                    <a href="{{ route('admin.manifests.export-room', ['package_id' => $selectedPackage]) }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg shadow font-medium hover:bg-gray-900 transition text-sm inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export CSV Room
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left: Unassigned Bucket -->
                <div class="lg:col-span-1 border-r pr-4 border-gray-100">
                    <h4 class="font-bold text-gray-400 text-[10px] uppercase tracking-widest mb-4">Jamaah Belum Di-plot</h4>
                    <div class="room-container bg-gray-50/50 p-4 rounded-2xl min-h-[300px] space-y-2 border-2 border-dashed border-gray-200" data-room="">
                        @php 
                            $unplotted = \App\Models\Manifest::whereHas('order', function($q) use ($selectedPackage) {
                                $q->where('package_id', $selectedPackage);
                            })->whereNull('room_list_id')->get();
                        @endphp
                        @forelse($unplotted as $up)
                            <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 cursor-move flex items-center" data-id="{{ $up->id }}">
                                <div class="w-2 h-6 bg-orange-400 rounded-full mr-3"></div>
                                <div>
                                    <div class="text-xs font-bold text-gray-800">
                                        {{ $up->full_name ?? ($up->order?->lead?->name ?? $up->order?->customer_name ?? '-') }}
                                    </div>
                                    @if(!$up->full_name)
                                        <div class="text-[9px] text-amber-600 font-bold">⚠ Nama paspor belum diisi</div>
                                    @else
                                        <div class="text-[9px] text-gray-400">{{ $up->gender }} | {{ $up->marital_status }}</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-[10px] text-center text-gray-400 py-10 italic">Semua jamaah sudah dikamar</div>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Room Grid -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($rooms as $room)
                        @php
                            $cap = match($room->room_type) { 'Quad' => 4, 'Triple' => 3, 'Double' => 2, 'Single' => 1, default => 2 };
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:border-wifa-green transition">
                            <div class="flex justify-between items-start mb-4 border-b border-gray-50 pb-2">
                                <div>
                                    <h4 class="font-black text-gray-800 text-sm">{{ $room->hotel_name }}</h4>
                                    <div class="text-[10px] font-bold text-wifa-green uppercase">{{ $room->room_type }} Room - #{{ $room->room_number ?? '-' }}</div>
                                </div>
                                <div class="text-xs font-black text-gray-300">{{ $cap }} Slots</div>
                            </div>
                            
                            <div class="room-container space-y-2 min-h-[100px]" data-room="{{ $room->id }}">
                                @php $assigned = \App\Models\Manifest::where('room_list_id', $room->id)->get(); @endphp
                                @foreach($assigned as $am)
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 cursor-move flex items-center" data-id="{{ $am->id }}">
                                        <div class="w-1.5 h-5 bg-wifa-green rounded-full mr-3"></div>
                                        <div class="text-xs font-bold text-gray-700 truncate flex-1">
                                        {{ $am->full_name ?? ($am->order?->lead?->name ?? $am->order?->customer_name ?? '-') }}
                                        @if(!$am->full_name)
                                            <span class="text-amber-500 text-[9px]">⚠</span>
                                        @endif
                                    </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Modal Add Room (kept current implementation but restyled) -->
            <div x-data="{ open: false }" @open-modal-add-room.window="open = true" class="relative z-50" x-show="open" style="display: none;">
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" @click="open = false"></div>
                <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
                    <form action="{{ route('admin.room-lists.store') }}" method="POST" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $selectedPackage }}">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between">
                            <h3 class="text-lg font-bold text-gray-800">Tambah Kamar Baru</h3>
                            <button type="button" @click="open = false" class="text-gray-400">&times;</button>
                        </div>
                        <div class="p-6 space-y-4 text-left">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Hotel Name</label>
                                <input type="text" name="hotel_name" class="w-full rounded-xl border-gray-200 text-sm focus:ring-wifa-green" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Room Number / Alias</label>
                                <input type="text" name="room_number" class="w-full rounded-xl border-gray-200 text-sm focus:ring-wifa-green">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tipe Kamar</label>
                                <select name="room_type" class="w-full rounded-xl border-gray-200 text-sm" required>
                                    <option value="Quad">Quad (4 Orang)</option>
                                    <option value="Triple">Triple (3 Orang)</option>
                                    <option value="Double">Double (2 Orang)</option>
                                    <option value="Single">Single (1 Orang)</option>
                                </select>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                            <button type="submit" class="bg-wifa-green text-wifa-gold px-6 py-2.5 font-bold rounded-xl shadow-sm hover:bg-green-800 transition">Buat Kamar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- TAB 3: BUS SEATING -->
    <div x-show="tab === 'bus'" style="display: none;">
        @if(!$selectedPackage)
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-5 py-4 rounded-xl shadow-sm text-center">
                Silakan filter/pilih **Paket Perjalanan** terlebih dahulu di atas untuk mengatur kursi bus jamaah.
            </div>
        @else
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Pengaturan Kursi Bus</h3>
                <a href="{{ route('admin.manifests.export-bus', ['package_id' => $selectedPackage]) }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg shadow font-medium hover:bg-gray-900 transition text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV Bus
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold">Nama Jamaah</th>
                            <th class="py-4 px-6 font-bold">Gender</th>
                            <th class="py-4 px-6 font-bold w-1/4">Assign Bus</th>
                            <th class="py-4 px-6 font-bold w-1/4">Assign Seat</th>
                            <th class="py-4 px-6 font-bold text-center">Simpan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @php 
                            $busManifests = \App\Models\Manifest::with('busSeater')->whereHas('order', function($q) use ($selectedPackage) {
                                $q->where('package_id', $selectedPackage);
                            })->get();
                        @endphp
                        @forelse($busManifests as $bm)
                        <tr class="hover:bg-gray-50 transition">
                            <form action="{{ route('admin.manifests.plot-bus', $bm->id) }}" method="POST">
                                @csrf
                                <td class="py-3 px-6 font-bold text-gray-800">
                                    {{ $bm->full_name ?? ($bm->order?->lead?->name ?? $bm->order?->customer_name ?? '-') }}
                                    @if(!$bm->full_name)
                                        <span class="ml-1 text-[9px] font-bold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full">dari pemesan</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6">{{ $bm->gender ?? '-' }}</td>
                                <td class="py-3 px-6">
                                    <input type="text" name="bus_number" value="{{ $bm->busSeater->bus_number ?? '' }}" placeholder="Contoh: 1" class="w-full rounded border-gray-300 text-sm focus:ring-wifa-green py-1">
                                </td>
                                <td class="py-3 px-6">
                                    <input type="text" name="seat_number" value="{{ $bm->busSeater->seat_number ?? '' }}" placeholder="Contoh: 01A" class="w-full rounded border-gray-300 text-sm focus:ring-wifa-green py-1">
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <button type="submit" class="bg-wifa-green text-wifa-gold px-3 py-1.5 rounded text-xs font-bold shadow hover:bg-green-800">Update</button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 text-center text-gray-400 font-medium">Belum ada jamaah di paket ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- TAB 4: PERLENGKAPAN -->
    <div x-show="tab === 'equipment'" style="display: none;">
        @if(!$selectedPackage)
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-5 py-4 rounded-xl shadow-sm text-center">
                Silakan filter/pilih **Paket Perjalanan** terlebih dahulu di atas untuk melihat status perlengkapan jamaah.
            </div>
        @else
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Distribusi Perlengkapan Jamaah</h3>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold">Nama Jamaah</th>
                            <th class="py-4 px-6 font-bold text-center">Koper</th>
                            <th class="py-4 px-6 font-bold text-center">Ihram/Mukena</th>
                            <th class="py-4 px-6 font-bold text-center">Batik</th>
                            <th class="py-4 px-6 font-bold text-center">Buku</th>
                            <th class="py-4 px-6 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @php 
                            $eqManifests = \App\Models\Manifest::whereHas('order', function($q) use ($selectedPackage) {
                                $q->where('package_id', $selectedPackage);
                            })->get();
                        @endphp
                        @forelse($eqManifests as $em)
                        <tr class="hover:bg-gray-50 transition">
                            <form action="{{ route('admin.manifests.update-equipment', $em->id) }}" method="POST">
                                @csrf
                                <td class="py-3 px-6 font-bold text-gray-800">
                                    {{ $em->full_name ?? ($em->order?->lead?->name ?? $em->order?->customer_name ?? '-') }}
                                    @if(!$em->full_name)
                                        <span class="ml-1 text-[9px] font-bold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full">dari pemesan</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <input type="checkbox" name="eq_koper" value="1" {{ $em->eq_koper ? 'checked' : '' }} class="w-5 h-5 text-wifa-green rounded border-gray-300 focus:ring-wifa-green cursor-pointer" onchange="this.form.submit()">
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <input type="checkbox" name="eq_ihram_mukena" value="1" {{ $em->eq_ihram_mukena ? 'checked' : '' }} class="w-5 h-5 text-wifa-green rounded border-gray-300 focus:ring-wifa-green cursor-pointer" onchange="this.form.submit()">
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <input type="checkbox" name="eq_seragam_batik" value="1" {{ $em->eq_seragam_batik ? 'checked' : '' }} class="w-5 h-5 text-wifa-green rounded border-gray-300 focus:ring-wifa-green cursor-pointer" onchange="this.form.submit()">
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <input type="checkbox" name="eq_buku_panduan" value="1" {{ $em->eq_buku_panduan ? 'checked' : '' }} class="w-5 h-5 text-wifa-green rounded border-gray-300 focus:ring-wifa-green cursor-pointer" onchange="this.form.submit()">
                                </td>
                                <td class="py-3 px-6 text-right text-xs text-gray-400 italic">
                                    Auto-save
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-8 text-center text-gray-400 font-medium">Belum ada jamaah di paket ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    function toggleDoc(manifestId, docType) {
        fetch(`/admin/manifests/${manifestId}/toggle-doc`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ document: docType })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById(`doc-${docType}-${manifestId}`);
                if (el) {
                    if (data.status) {
                        el.classList.remove('bg-red-500', 'shadow-red-200');
                        el.classList.add('bg-green-500', 'shadow-green-200');
                    } else {
                        el.classList.remove('bg-green-500', 'shadow-green-200');
                        el.classList.add('bg-red-500', 'shadow-red-200');
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Sortable for Room Assignments
        const containers = document.querySelectorAll('.room-container');
        containers.forEach(el => {
            new Sortable(el, {
                group: 'rooms',
                animation: 150,
                ghostClass: 'bg-wifa-green/10',
                onAdd: function (evt) {
                    const manifestId = evt.item.dataset.id;
                    const roomId = evt.to.dataset.room;
                    updateManifestRoom(manifestId, roomId);
                }
            });
        });
    });

    function updateManifestRoom(manifestId, roomId) {
        fetch(`/admin/manifests/${manifestId}/transfer-room`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ room_list_id: roomId || null })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Optional: show toast
                console.log('Room updated');
            }
        });
    }
</script>
@endsection