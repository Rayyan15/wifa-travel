@extends('layouts.admin')
@section('title', 'Manajemen Testimoni')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Testimoni</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola testimoni jamaah untuk ditampilkan di halaman depan.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Testimoni
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        @if($testimonials->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada testimoni</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai tambahkan testimoni jamaah yang puas.</p>
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($testimonials as $testimonial)
                <li class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($testimonial->image)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                                    {{ substr($testimonial->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $testimonial->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $testimonial->role ?? 'Jamaah' }}</p>
                            <p class="text-sm text-gray-700 mt-1 line-clamp-2">{{ $testimonial->content }}</p>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-end space-y-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 sm:px-6">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
