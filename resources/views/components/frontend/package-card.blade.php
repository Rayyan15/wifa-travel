@props(['package'])

<div x-data="{}" class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-gray-100 hover:-translate-y-2 transition duration-300 group flex flex-col h-full relative">
    
    <!-- Thumbnail Image -->
    @if($package->thumbnail)
    <div class="relative aspect-[4/5] overflow-hidden">
        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
        <div class="absolute inset-0 bg-gradient-to-t from-wifa-green/90 via-transparent to-transparent"></div>
        <!-- Type Badge on Image -->
        <div class="absolute top-4 left-4">
            <span class="bg-wifa-gold text-wifa-green font-black text-xs tracking-[0.15em] uppercase px-4 py-2 rounded-full shadow-lg">PAKET {{ $package->type ?? 'REGULER' }}</span>
        </div>
        <!-- Title on Image -->
        <div class="absolute bottom-4 left-4 right-4">
            <h3 class="text-white font-bold text-xl md:text-2xl drop-shadow-lg leading-tight">{{ $package->name }}</h3>
            <span class="text-white/90 text-sm font-medium mt-1 block">Keberangkatan: {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('d F Y') }}</span>
        </div>
    </div>
    @else
    <!-- Fallback: Header without thumbnail -->
    <div class="bg-wifa-green pb-4 pt-6 px-6 relative overflow-hidden text-center z-0">
        <div class="absolute -right-8 -top-8 w-24 h-24 bg-wifa-gold/20 rounded-full blur-xl"></div>
        <div class="absolute -left-10 -bottom-10 w-20 h-20 bg-wifa-gold/10 rounded-full blur-xl"></div>
        
        <h3 class="text-wifa-gold font-bold text-xl md:text-2xl uppercase tracking-wider relative z-10 drop-shadow-md">{{ $package->name }}</h3>
        <span class="inline-block bg-wifa-gold/20 border border-wifa-gold/30 text-white font-black text-sm px-4 py-1.5 rounded relative z-10 mt-2 tracking-wide">KEBERANGKATAN: {{ \Carbon\Carbon::parse($package->departure_date)->translatedFormat('F Y') }}</span>
    </div>

    <!-- Type Label -->
    <div class="bg-wifa-gold py-2 text-center shadow-inner relative z-10">
        <span class="text-wifa-dark font-black text-sm tracking-[0.2em] uppercase">PAKET {{ $package->type ?? 'REGULER' }}</span>
    </div>
    @endif

    <!-- Price Section -->
    <div class="text-center pt-6 pb-4">
        <span class="text-gray-400 text-sm uppercase tracking-widest font-bold">Mulai Dari</span>
        <div class="text-wifa-green font-black text-4xl mt-1 tracking-tight flex items-baseline justify-center">
            <span class="text-2xl mr-1">Rp</span> 
            <span>{{ number_format($package->price / 1000000, 1, ',', '.') }}</span>
            <span class="text-xl ml-1 text-gray-400">Jt</span>
        </div>
        <div class="text-xs text-wifa-gold font-bold uppercase mt-1 tracking-widest bg-wifa-gold/10 inline-block px-3 py-1 rounded">All In</div>
    </div>

    <!-- Divider -->
    <div class="px-8"><div class="border-t-2 border-dashed border-gray-200"></div></div>

    <!-- Details -->
    <div class="px-8 py-5 flex-grow space-y-4">
        <div class="flex items-start">
            <div class="w-8 h-8 rounded-lg bg-green-50 text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Hotel Mekkah</span>
                <span class="block text-base font-bold text-gray-800">{{ $package->hotel_mekkah ?? 'Setaraf Bintang 5' }}</span>
            </div>
        </div>
        <div class="flex items-start">
            <div class="w-8 h-8 rounded-lg bg-yellow-50 text-wifa-gold flex items-center justify-center shrink-0 mt-0.5 mr-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Hotel Madinah</span>
                <span class="block text-base font-bold text-gray-800">{{ $package->hotel_madinah ?? 'Setaraf Bintang 5' }}</span>
            </div>
        </div>
        <div class="flex items-start">
            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5 mr-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Maskapai Penerbangan</span>
                <span class="block text-base font-bold text-gray-800">{{ $package->airline ?? 'Saudi Airlines / Garuda' }}</span>
            </div>
        </div>
    </div>

    <!-- Download Buttons (Itinerary & Brosur) -->
    @if($package->itinerary_pdf || $package->brosur_pdf)
    <div class="px-6 pb-4">
        <div class="flex gap-2">
            @if($package->itinerary_pdf)
            <a href="{{ asset('storage/' . $package->itinerary_pdf) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-green-50 text-wifa-green border border-green-200 px-3 py-3 rounded-xl text-sm font-bold hover:bg-green-100 hover:border-green-300 transition duration-200 group/btn">
                <svg class="w-4 h-4 group-hover/btn:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Itinerary
            </a>
            @endif
            @if($package->brosur_pdf)
            <a href="{{ asset('storage/' . $package->brosur_pdf) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-3 rounded-xl text-sm font-bold hover:bg-amber-100 hover:border-amber-300 transition duration-200 group/btn">
                <svg class="w-4 h-4 group-hover/btn:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Brosur
            </a>
            @endif
        </div>
    </div>
    @endif

    <!-- CTA & Footer -->
    <div class="px-6 py-5 mt-auto bg-gray-50 border-t border-gray-100">
        <div class="flex justify-between items-center mb-3 px-2">
            <span class="text-sm text-gray-500 font-medium">Sisa Seat:</span>
            <span class="text-base font-black {{ $package->remaining_seats < 10 ? 'text-red-500' : 'text-wifa-green' }}">
                {{ $package->remaining_seats }} / {{ $package->total_seats }}
            </span>
        </div>
        
        <button type="button" @click="$dispatch('open-booking-modal', { id: {{ $package->id }}, name: '{{ addslashes($package->name) }}' })" 
                class="block w-full py-4 text-base bg-wifa-dark text-wifa-gold text-center font-bold rounded-xl shadow-[0_10px_20px_rgba(17,43,32,0.15)] hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(17,43,32,0.3)] overflow-hidden relative group transition duration-300">
            <span class="relative z-10 group-hover:text-white transition duration-300">Detail & Daftar</span>
            <div class="absolute inset-0 h-full w-full bg-wifa-gold-hover scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500 ease-out z-0"></div>
        </button>
    </div>
</div>
