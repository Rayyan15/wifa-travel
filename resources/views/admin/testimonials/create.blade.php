@extends('layouts.admin')
@section('title', 'Tambah Testimoni')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Testimoni</h1>
            <p class="mt-1 text-sm text-gray-500">Buat testimoni baru untuk ditampilkan di website.</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        @csrf
        <div class="p-6 space-y-6">
            
            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Jamaah <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Peran / Keterangan (Opsional)</label>
                <input type="text" name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('role') }}" placeholder="Contoh: Jamaah Umroh Plus / Direktur PT ABC">
                @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating (Bintang)</label>
                <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Bintang - Sangat Puas</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Bintang - Puas</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Bintang - Cukup</option>
                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Bintang - Kurang</option>
                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Bintang - Sangat Kurang</option>
                </select>
                @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Isi Testimoni <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tuliskan ulasan atau testimoni di sini...">{{ old('content') }}</textarea>
                @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Foto Profil (Opsional)</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_active" class="font-medium text-gray-700">Tampilkan Testimoni</label>
                    <p class="text-gray-500">Jika dicentang, testimoni ini akan muncul di halaman depan website.</p>
                </div>
            </div>

        </div>
        <div class="px-6 py-4 bg-gray-50 flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan Testimoni
            </button>
        </div>
    </form>
</div>
@endsection
