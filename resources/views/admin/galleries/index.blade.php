@extends('layouts.admin')
@section('title', 'Galeri Perjalanan Jamaah')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Upload Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Upload Foto Baru</h3>
            <p class="text-sm text-gray-400 mb-6">Upload beberapa foto sekaligus untuk galeri landing page.</p>

            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" x-data="{ previews: [] }">
                @csrf

                <!-- Drag & Drop Area -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Foto <span class="text-red-400">*</span></label>
                    <div class="relative border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-wifa-gold transition duration-300 cursor-pointer bg-gray-50/50"
                         @dragover.prevent="$el.classList.add('border-wifa-gold', 'bg-yellow-50/30')"
                         @dragleave.prevent="$el.classList.remove('border-wifa-gold', 'bg-yellow-50/30')"
                         @drop.prevent="
                            $el.classList.remove('border-wifa-gold', 'bg-yellow-50/30');
                            $refs.fileInput.files = $event.dataTransfer.files;
                            previews = [];
                            for (let f of $event.dataTransfer.files) {
                                let reader = new FileReader();
                                reader.onload = (e) => previews.push(e.target.result);
                                reader.readAsDataURL(f);
                            }
                         ">
                        <input type="file" name="images[]" multiple accept="image/*" x-ref="fileInput"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               @change="
                                    previews = [];
                                    for (let f of $event.target.files) {
                                        let reader = new FileReader();
                                        reader.onload = (e) => previews.push(e.target.result);
                                        reader.readAsDataURL(f);
                                    }
                               ">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-wifa-green/10 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-wifa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-600">Drag & drop atau klik untuk pilih</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — Maks 5MB per file</p>
                        </div>
                    </div>
                </div>

                <!-- Preview Grid -->
                <div x-show="previews.length > 0" class="mb-5">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Preview (<span x-text="previews.length"></span> foto)</p>
                    <div class="grid grid-cols-3 gap-2">
                        <template x-for="(src, i) in previews" :key="i">
                            <div class="aspect-square rounded-xl overflow-hidden border border-gray-200">
                                <img :src="src" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-wifa-gold/30 focus:border-wifa-gold transition outline-none text-sm" placeholder="Cth: Umroh Reguler Mei 2026">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                    <input type="text" name="caption" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl focus:ring-2 focus:ring-wifa-gold/30 focus:border-wifa-gold transition outline-none text-sm" placeholder="Cth: Jamaah di depan Ka'bah">
                </div>

                <button type="submit" class="w-full bg-wifa-green text-white font-bold py-3.5 rounded-xl hover:bg-wifa-hover transition duration-300 flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    Upload ke Galeri
                </button>
            </form>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Semua Foto</h3>
                <p class="text-sm text-gray-400">{{ $galleries->count() }} foto dalam galeri</p>
            </div>
        </div>

        @if($galleries->isEmpty())
            <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm p-16 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-600 mb-2">Belum ada foto</h4>
                <p class="text-sm text-gray-400">Upload foto pertama Anda menggunakan form di sebelah kiri.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($galleries as $gallery)
                    <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition duration-300" x-data="{ editing: false }">
                        <!-- Image -->
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title ?? 'Galeri Jamaah' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>

                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                            <!-- Info -->
                            <div class="mb-3">
                                @if($gallery->title)
                                    <p class="text-white font-bold text-sm truncate">{{ $gallery->title }}</p>
                                @endif
                                @if($gallery->caption)
                                    <p class="text-gray-300 text-xs truncate">{{ $gallery->caption }}</p>
                                @endif
                                <p class="text-gray-400 text-[10px] mt-1">{{ $gallery->created_at->format('d M Y') }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button @click="editing = true" class="flex-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold py-2 rounded-lg hover:bg-white/30 transition">
                                    <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </button>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500/80 backdrop-blur-sm text-white text-xs font-bold py-2 rounded-lg hover:bg-red-600 transition">
                                        <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-block w-3 h-3 rounded-full {{ $gallery->is_active ? 'bg-green-400 shadow-[0_0_6px_rgba(74,222,128,0.6)]' : 'bg-gray-400' }}"></span>
                        </div>

                        <!-- Edit Modal Overlay -->
                        <div x-show="editing" x-transition.opacity class="absolute inset-0 bg-white z-20 p-4 flex flex-col" style="display: none;">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-sm text-gray-800">Edit Foto</h4>
                                <button @click="editing = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" class="flex-1 flex flex-col">
                                @csrf
                                @method('PUT')
                                <input type="text" name="title" value="{{ $gallery->title }}" placeholder="Judul" class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg text-sm mb-2 focus:ring-1 focus:ring-wifa-gold focus:border-wifa-gold outline-none">
                                <input type="text" name="caption" value="{{ $gallery->caption }}" placeholder="Keterangan" class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg text-sm mb-2 focus:ring-1 focus:ring-wifa-gold focus:border-wifa-gold outline-none">
                                <input type="number" name="sort_order" value="{{ $gallery->sort_order }}" placeholder="Urutan" class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg text-sm mb-2 focus:ring-1 focus:ring-wifa-gold focus:border-wifa-gold outline-none">
                                <label class="flex items-center gap-2 text-sm text-gray-600 mb-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ $gallery->is_active ? 'checked' : '' }} class="rounded text-wifa-green focus:ring-wifa-gold">
                                    Tampilkan di Landing Page
                                </label>
                                <button type="submit" class="mt-auto w-full bg-wifa-green text-white font-bold py-2.5 rounded-lg hover:bg-wifa-hover transition text-sm">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
