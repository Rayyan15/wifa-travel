@extends('layouts.admin')
@section('title', 'Tambah Paket Baru')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Paket</label>
                <input type="text" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Paket</label>
                <select name="type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
                    <option value="haji">Haji</option>
                    <option value="umroh">Umroh</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keberangkatan</label>
                <input type="date" name="departure_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kepulangan</label>
                <input type="date" name="return_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maskapai</label>
                <input type="text" name="airline" class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hotel Mekkah</label>
                <input type="text" name="hotel_mekkah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hotel Madinah</label>
                <input type="text" name="hotel_madinah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50">
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap</label>
            <textarea name="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-wifa-gold focus:ring focus:ring-wifa-gold focus:ring-opacity-50"></textarea>
        </div>
        <div class="flex justify-end"><button type="submit" class="bg-wifa-green text-wifa-gold font-bold py-3 px-8 rounded-lg shadow-md hover:bg-green-900 transition-all border border-wifa-gold">Simpan Paket</button></div>
    </form>
</div>
@endsection