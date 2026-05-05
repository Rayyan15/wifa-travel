@extends('layouts.admin')
@section('title', 'Manajemen User')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Daftar Pengguna Sistem</h3>
        <button x-data @click="$dispatch('open-modal', 'create-user-modal')" class="bg-wifa-green hover:bg-wifa-hover text-wifa-gold px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 font-medium">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email & No WA</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Komisi (%)</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $usr)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $usr->name }}</td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $usr->email }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $usr->phone ?: '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $roleBadge = match($usr->role) {
                                'superadmin' => ['label'=>'Super Admin','cls'=>'bg-gray-200 text-gray-800'],
                                'sales'      => ['label'=>'Sales','cls'=>'bg-blue-100 text-blue-700'],
                                'agen'       => ['label'=>'Agen','cls'=>'bg-indigo-100 text-indigo-700'],
                                'partner'    => ['label'=>'Partner','cls'=>'bg-emerald-100 text-emerald-700'],
                                default      => ['label'=>'User','cls'=>'bg-gray-100 text-gray-700'],
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider {{ $roleBadge['cls'] }}">
                            {{ $roleBadge['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium font-mono">
                        {{ in_array($usr->role, ['agen','partner']) ? $usr->commission_rate . '%' : '-' }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button x-data @click="$dispatch('open-modal', 'edit-user-{{ $usr->id }}')" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded-lg transition" title="Edit User">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        @if(auth()->id() !== $usr->id)
                            <button x-data @click="$dispatch('open-modal', 'delete-user-{{ $usr->id }}')" class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Hapus User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        @endif
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-user-{{ $usr->id }}') open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="open" @click="open = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-900 opacity-50"></div></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="open" x-transition.scale.origin.bottom class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Pengguna</h3>
                            <form action="{{ route('admin.users.update', $usr->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ $usr->name }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" value="{{ $usr->email }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                        <input type="text" name="phone" value="{{ $usr->phone }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                                        <select name="role" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                                            <option value="superadmin" {{ $usr->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="sales" {{ $usr->role === 'sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="agen" {{ $usr->role === 'agen' ? 'selected' : '' }}>Agen</option>
                                            <option value="partner" {{ $usr->role === 'partner' ? 'selected' : '' }}>Partner</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Komisi (%) <span class="text-xs text-gray-500 font-normal ml-1">Kecuali superadmin/sales</span></label>
                                        <input type="number" step="0.01" min="0" max="100" name="commission_rate" value="{{ $usr->commission_rate }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Password <span class="text-xs text-gray-500 font-normal ml-1">Kosongkan jika tidak ingin diubah</span></label>
                                        <input type="password" name="password" placeholder="Password Baru..." class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                                    </div>
                                </div>
                                <div class="mt-6 sm:flex sm:flex-row-reverse border-t border-gray-100 pt-4">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-wifa-green text-base font-medium text-wifa-gold hover:bg-wifa-hover focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Simpan Perubahan</button>
                                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Delete --}}
                <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'delete-user-{{ $usr->id }}') open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="open" @click="open = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-900 opacity-50"></div></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="open" x-transition.scale.origin.bottom class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-headline">Hapus Pengguna</h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p>Apakah Anda yakin ingin menghapus akun <b>{{ $usr->name }}</b>? Tindakan ini tidak dapat dibatalkan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Ya, Hapus</button>
                                </form>
                                <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

{{-- Modal Create --}}
<div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'create-user-modal') open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div x-show="open" @click="open = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-900 opacity-50"></div></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div x-show="open" x-transition.scale.origin.bottom class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Pengguna Baru</h3>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                            <option value="sales">Sales</option>
                            <option value="agen">Agen</option>
                            <option value="partner">Partner</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Komisi (%) <span class="text-xs text-gray-500 font-normal ml-1">Kecuali superadmin/sales</span></label>
                        <input type="number" step="0.01" min="0" max="100" name="commission_rate" value="{{ old('commission_rate', 0) }}" class="w-full rounded-lg border-gray-300 focus:border-wifa-green focus:ring focus:ring-wifa-green/20">
                    </div>
                </div>
                <div class="mt-6 sm:flex sm:flex-row-reverse border-t border-gray-100 pt-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-wifa-green text-base font-medium text-wifa-gold hover:bg-wifa-hover focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Simpan Pengguna</button>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
