@extends('layouts.admin')
@section('title', 'Manajemen Leads')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Leads (Calon Jamaah)</h2>
    <div class="flex space-x-3">
        <a href="{{ route('admin.leads.export-csv') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition font-semibold flex items-center text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel (CSV)
        </a>
        <button onclick="openModal('addLeadModal')" class="bg-wifa-green text-wifa-gold px-5 py-2.5 rounded-lg shadow-md hover:bg-green-900 border border-wifa-gold transition font-semibold flex items-center text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Lead
        </button>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                    <th class="py-4 px-6 font-bold">Nama</th>
                    <th class="py-4 px-6 font-bold">WhatsApp</th>
                    <th class="py-4 px-6 font-bold">Paket Diminati</th>
                    <th class="py-4 px-6 font-bold">Tanggal Masuk</th>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales')
                        <th class="py-4 px-6 font-bold">Pemilik / Agen</th>
                    @endif
                    <th class="py-4 px-6 font-bold text-right">Status / Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($leads as $lead)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-6 font-semibold">{{ $lead->name }}</td>
                    <td class="py-4 px-6"><a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $lead->whatsapp)) }}" target="_blank" class="text-green-600 hover:text-green-800 font-medium font-mono">WA: {{ $lead->whatsapp }}</a></td>
                    <td class="py-4 px-6">{{ $lead->package->name ?? '-' }}</td>
                    <td class="py-4 px-6">{{ $lead->created_at->format('d M Y - H:i') }}</td>
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales')
                    <td class="py-4 px-6">
                        @if($lead->user_id)
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $lead->user->role === 'partner' ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }} uppercase tracking-wider">
                                {{ $lead->user->name }} ({{ ucfirst($lead->user->role) }})
                            </span>
                        @else
                            <span class="text-xs text-gray-400 italic">Daftar Mandiri Web</span>
                        @endif
                    </td>
                    @endif
                    <td class="py-4 px-6 text-right">
                        @if($lead->status === 'lunas' || $lead->status === 'ordered')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1.5 rounded-full border border-green-200 uppercase">{{ $lead->status }}</span>
                        @else
                            <form action="{{ route('admin.leads.update-status', $lead->id) }}" method="POST" class="inline-flex items-center">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50 py-1 pr-7 pl-2 font-semibold uppercase 
                                    {{ $lead->status === 'pending' ? 'bg-yellow-50 text-yellow-800' : ($lead->status === 'contacted' ? 'bg-blue-50 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    <option value="pending" {{ $lead->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="ordered" {{ $lead->status === 'ordered' ? 'selected' : '' }}>+ Convert to ORDER</option>
                                    <option value="lunas" {{ $lead->status === 'lunas' ? 'selected' : '' }}>+ Convert to LUNAS</option>
                                </select>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ (auth()->user()->role === 'superadmin' || auth()->user()->role === 'sales') ? 6 : 5 }}" class="py-8 text-center text-gray-400 font-medium">Belum ada leads yang masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $leads->links('pagination::tailwind') }}</div>

<!-- Modal Add Lead -->
<div id="addLeadModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-wifa-green">Tambah Lead Baru</h3>
            <button onclick="closeModal('addLeadModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.leads.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Calon Jamaah</label>
                <input type="text" name="name" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (Contoh: 0812...)</label>
                <input type="text" name="whatsapp" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ketertarikan Pada Paket</label>
                <select name="package_id" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                    <option value="">- Pilih Paket Pilihan -</option>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Awal</label>
                <select name="status" required class="w-full rounded-md border-gray-300 focus:border-wifa-gold">
                    <option value="pending">PENDING (Belum Dihubungi)</option>
                    <option value="contacted">CONTACTED (Sudah Dihubungi)</option>
                    <option value="closed">CLOSED (Batal)</option>
                    <option value="ordered">ORDERED (Memesan)</option>
                    <option value="lunas">LUNAS (Langsung Bayar)</option>
                </select>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeModal('addLeadModal')" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="submit" class="bg-wifa-green text-wifa-gold px-6 py-2 rounded shadow hover:bg-green-900 font-bold">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endsection
