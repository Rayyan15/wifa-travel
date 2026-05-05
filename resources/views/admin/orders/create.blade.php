@extends('layouts.admin')
@section('title', 'Tambah Pemesanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Pemesanan Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Buat data transaksi order baru untuk jamaah.</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-200 bg-white px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
<div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 text-sm">
    <p class="font-bold mb-1">Terdapat kesalahan input:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        {{-- Package --}}
        <div class="mb-5">
            <label for="package_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Paket Perjalanan <span class="text-red-500">*</span>
            </label>
            <select name="package_id" id="package_id" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-wifa-green focus:border-transparent transition @error('package_id') border-red-400 @enderror">
                <option value="">-- Pilih Paket --</option>
                @foreach ($packages as $package)
                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                        {{ $package->name }} — Rp {{ number_format($package->price, 0, ',', '.') }}
                        (Sisa kursi: {{ $package->remaining_seats }})
                    </option>
                @endforeach
            </select>
            @error('package_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Lead / Pemesan --}}
        <div class="mb-5">
            <label for="lead_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Pemesan (Lead) <span class="text-gray-400 font-normal text-xs">(opsional)</span>
            </label>
            <select name="lead_id" id="lead_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-wifa-green focus:border-transparent transition @error('lead_id') border-red-400 @enderror">
                <option value="">-- Tidak ada / Tanpa Lead (Isi manual di bawah) --</option>
                @foreach ($leads as $lead)
                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                        {{ $lead->name }} — {{ $lead->whatsapp ?? 'No WA tidak tersedia' }}
                    </option>
                @endforeach
            </select>
            @error('lead_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
                <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama Pemesan Manual <span class="text-gray-400 font-normal text-xs">(Jika tanpa Lead)</span>
                </label>
                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-wifa-green focus:border-transparent transition @error('customer_name') border-red-400 @enderror">
                @error('customer_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    No WhatsApp <span class="text-gray-400 font-normal text-xs">(Jika tanpa Lead)</span>
                </label>
                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-wifa-green focus:border-transparent transition @error('customer_phone') border-red-400 @enderror">
                @error('customer_phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Total Amount --}}
        <div class="mb-5">
            <label for="total_amount" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Total Harga (Rp) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                <input type="number" name="total_amount" id="total_amount"
                    value="{{ old('total_amount') }}"
                    min="0" step="1000" required
                    placeholder="0"
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-wifa-green focus:border-transparent transition @error('total_amount') border-red-400 @enderror">
            </div>
            @error('total_amount')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Payment Status --}}
        <div class="mb-7">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Status Pembayaran <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-3 flex-wrap">
                @foreach (['unpaid' => ['label' => 'Belum Bayar', 'color' => 'yellow'], 'partial' => ['label' => 'DP / Partial', 'color' => 'blue'], 'paid' => ['label' => 'Lunas', 'color' => 'green']] as $value => $opt)
                <label class="relative cursor-pointer">
                    <input type="radio" name="payment_status" value="{{ $value }}"
                        {{ old('payment_status', 'unpaid') === $value ? 'checked' : '' }}
                        class="peer absolute opacity-0 w-0 h-0">
                    <span class="inline-block border-2 border-gray-200 rounded-lg px-5 py-2.5 text-sm font-semibold text-gray-500
                        peer-checked:border-wifa-green peer-checked:bg-green-50 peer-checked:text-wifa-green transition select-none">
                        {{ $opt['label'] }}
                    </span>
                </label>
                @endforeach
            </div>
            @error('payment_status')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
            <button type="submit"
                class="bg-wifa-green text-wifa-gold font-semibold px-6 py-2.5 rounded-lg shadow hover:bg-green-800 transition text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Order
            </button>
            <a href="{{ route('admin.orders.index') }}"
                class="border border-gray-300 text-gray-600 font-medium px-6 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
