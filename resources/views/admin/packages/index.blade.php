@extends('layouts.admin')
@section('title', 'Manajemen Paket Travel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Paket</h2>
    <button onclick="openModal('addPackageModal')" class="bg-wifa-green text-wifa-gold px-5 py-2.5 rounded-lg shadow-md hover:bg-green-900 border border-wifa-gold transition font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Paket
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-bold">Thumbnail</th>
                    <th class="py-4 px-6 font-bold">Nama Paket</th>
                    <th class="py-4 px-6 font-bold">Tipe</th>
                    <th class="py-4 px-6 font-bold">Keberangkatan</th>
                    <th class="py-4 px-6 font-bold">Seats (Sisa/Total)</th>
                    <th class="py-4 px-6 font-bold">Harga</th>
                    <th class="py-4 px-6 font-bold">Files</th>
                    <th class="py-4 px-6 font-bold">Status</th>
                    <th class="py-4 px-6 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($packages as $package)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-6">
                        @if($package->thumbnail)
                            <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-14 h-14 rounded-lg object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-6 font-semibold">{{ $package->name }}</td>
                    <td class="py-4 px-6">
                        @if($package->type === 'VIP')
                            <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded">VIP</span>
                        @elseif($package->type === 'PLUS')
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">PLUS</span>
                        @else
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-1 rounded">REGULER</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">{{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d M Y') }}</td>
                    <td class="py-4 px-6 font-mono">{{ $package->remaining_seats }} / {{ $package->total_seats }}</td>
                    <td class="py-4 px-6">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                    <td class="py-4 px-6">
                        <div class="flex gap-1">
                            @if($package->itinerary_pdf)
                                <a href="{{ asset('storage/' . $package->itinerary_pdf) }}" target="_blank" title="Itinerary" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition border border-green-200">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </a>
                            @endif
                            @if($package->brosur_pdf)
                                <a href="{{ asset('storage/' . $package->brosur_pdf) }}" target="_blank" title="Brosur" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition border border-amber-200">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </a>
                            @endif
                            @if(!$package->itinerary_pdf && !$package->brosur_pdf)
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        @if($package->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full border border-green-200">Active</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full border border-red-200">Inactive</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button 
                                type="button"
                                data-package="{{ $package->toJson() }}"
                                onclick="openEditModal(JSON.parse(this.getAttribute('data-package')))"
                                class="text-blue-600 hover:text-blue-800 font-medium text-xs px-2 py-1 rounded hover:bg-blue-50 transition"
                            >
                                Edit
                            </button>
                            <button 
                                type="button" 
                                onclick="openDeleteModal('{{ route('admin.packages.destroy', $package) }}', '{{ addslashes($package->name) }}')" 
                                class="text-red-600 hover:text-red-800 font-medium text-xs px-2 py-1 rounded hover:bg-red-50 transition flex items-center gap-1"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="py-8 text-center text-gray-400 font-medium">Belum ada paket travel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $packages->links('pagination::tailwind') }}</div>

<!-- Modal Add Package -->
<div id="addPackageModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-wifa-green">Tambah Paket Baru</h3>
            <button onclick="closeModal('addPackageModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                    <input type="text" name="name" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type (Badge)</label>
                    <select name="type" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                        <option value="REGULER">REGULER</option>
                        <option value="PLUS">PLUS</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Departure Date</label>
                    <input type="date" name="departure_date" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
                    <input type="date" name="return_date" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Seats</label>
                    <input type="number" name="total_seats" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (IDR)</label>
                    <input type="number" name="price" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotel Mekkah</label>
                    <input type="text" name="hotel_mekkah" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotel Madinah</label>
                    <input type="text" name="hotel_madinah" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Airline</label>
                    <input type="text" name="airline" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manasik Date</label>
                    <input type="date" name="manasik_date" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
            </div>
            
            <div class="mt-4 border-t pt-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📸 Thumbnail Image</span>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-xs mt-2">
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📑 Itinerary PDF</span>
                        <input type="file" name="itinerary_pdf" accept="application/pdf" class="w-full text-xs mt-2">
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📄 Brosur PDF</span>
                        <input type="file" name="brosur_pdf" accept="application/pdf" class="w-full text-xs mt-2">
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 focus:border-wifa-gold"></textarea>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal('addPackageModal')" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="submit" class="bg-wifa-green text-wifa-gold px-6 py-2 rounded shadow hover:bg-green-900 font-bold">Simpan Paket</button>
            </div>
        </form>
    </div>
</div> <!-- Close addPackageModal -->
<!-- Modal Edit Package -->
<div id="editPackageModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-wifa-green">Edit Paket</h3>
            <button onclick="closeModal('editPackageModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="editPackageForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                    <input type="text" name="name" id="edit_name" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type (Badge)</label>
                    <select name="type" id="edit_type" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                        <option value="REGULER">REGULER</option>
                        <option value="PLUS">PLUS</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Departure Date</label>
                    <input type="date" name="departure_date" id="edit_departure_date" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
                    <input type="date" name="return_date" id="edit_return_date" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Seats</label>
                    <input type="number" name="total_seats" id="edit_total_seats" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (IDR)</label>
                    <input type="number" name="price" id="edit_price" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotel Mekkah</label>
                    <input type="text" name="hotel_mekkah" id="edit_hotel_mekkah" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hotel Madinah</label>
                    <input type="text" name="hotel_madinah" id="edit_hotel_madinah" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Airline</label>
                    <input type="text" name="airline" id="edit_airline" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manasik Date</label>
                    <input type="date" name="manasik_date" id="edit_manasik_date" class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                </div>
            </div>
            
            <div class="mt-4 border-t pt-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📸 Thumbnail Image</span>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-xs mt-2">
                    </label>
                    <p class="text-[10px] text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📑 Itinerary PDF</span>
                        <input type="file" name="itinerary_pdf" accept="application/pdf" class="w-full text-xs mt-2">
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 border p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 text-center">
                        <span class="block">📄 Brosur PDF</span>
                        <input type="file" name="brosur_pdf" accept="application/pdf" class="w-full text-xs mt-2">
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="edit_description" rows="3" class="w-full rounded-md border-gray-300 focus:border-wifa-gold"></textarea>
            </div>
            
            <div class="mt-4 flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="rounded text-wifa-green focus:ring-wifa-green">
                <label for="edit_is_active" class="text-sm font-medium text-gray-700">Paket Aktif</label>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal('editPackageModal')" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="submit" class="bg-wifa-green text-wifa-gold px-6 py-2 rounded shadow hover:bg-green-900 font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black/60 hidden z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-max-w-sm overflow-hidden border border-gray-100 animate-fade-in-up">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-gray-500 mb-8 leading-relaxed" id="deleteConfirmText">Apakah Anda yakin ingin menghapus paket ini? Semua data terkait (leads, orders, manifest) akan ikut terhapus.</p>
            
            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="closeModal('deleteConfirmModal')" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-full hover:bg-gray-200 transition">Batal</button>
                <button type="button" onclick="executeDelete()" class="px-6 py-3 bg-red-600 text-white font-bold rounded-full hover:bg-red-700 shadow-lg shadow-red-200 transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Hidden Delete Form (outside table overflow) -->
<form id="deletePackageForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    let deleteUrl = "";

    function openEditModal(package) {
        const form = document.getElementById('editPackageForm');
        form.action = '/admin/packages/' + package.id;
        
        document.getElementById('edit_name').value = package.name;
        document.getElementById('edit_type').value = package.type;
        document.getElementById('edit_departure_date').value = package.departure_date;
        document.getElementById('edit_return_date').value = package.return_date;
        document.getElementById('edit_total_seats').value = package.total_seats;
        document.getElementById('edit_price').value = parseInt(package.price);
        document.getElementById('edit_hotel_mekkah').value = package.hotel_mekkah || '';
        document.getElementById('edit_hotel_madinah').value = package.hotel_madinah || '';
        document.getElementById('edit_airline').value = package.airline || '';
        document.getElementById('edit_manasik_date').value = package.manasik_date || '';
        document.getElementById('edit_description').value = package.description || '';
        document.getElementById('edit_is_active').checked = package.is_active == 1;

        openModal('editPackageModal');
    }

    function openDeleteModal(url, name) {
        deleteUrl = url;
        document.getElementById('deleteConfirmText').innerHTML = `Apakah Anda yakin ingin menghapus paket <b>"${name}"</b>? Semua data terkait akan ikut terhapus secara permanen.`;
        openModal('deleteConfirmModal');
    }

    function executeDelete() {
        if (!deleteUrl) return;
        var form = document.getElementById('deletePackageForm');
        form.action = deleteUrl;
        form.submit();
    }
</script>
@endsection
