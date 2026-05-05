@extends('layouts.frontend')
@section('title', 'Perjalanan Ibadah yang Tenang & Terencana')

@section('content')


<!-- Hero Section (Destinations Banner) -->
<section id="hero" class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden min-h-[75vh] flex items-center">
    <!-- Background Image with Parallax -->
    <div class="absolute inset-0 overflow-hidden bg-[#112b20]">
        <img src="{{ asset('images/content/makkah-hero.jpg') }}" alt="Makkah Al Mukarramah" class="w-full h-full object-cover object-center parallax-bg scale-110 zoom-on-scroll">
        <!-- Multi-layer Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#112b20]/80 via-[#1B4332]/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#112b20]/80 via-transparent to-[#1B4332]/20"></div>
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23D4AF37\' fill-opacity=\'0.3\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Content -->
    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
        <div class="max-w-xl">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-base md:text-lg mb-4 block drop-shadow reveal-left">Destinasi Suci</span>
            <div class="line-accent mb-6"></div>
            <h1 class="text-5xl md:text-6xl lg:text-8xl font-black text-white tracking-tight leading-tight mb-6 drop-shadow-lg reveal-left" style="transition-delay: 0.1s">Jalan Mudah Menuju<br>Baitullah</h1>
            <p class="text-white/90 text-xl md:text-2xl leading-relaxed mb-10 drop-shadow reveal-left" style="transition-delay: 0.2s">Nikmati perjalanan ibadah ke Tanah Suci dengan fasilitas premium dan pelayanan sepenuh hati.</p>
            <a href="#paket" class="inline-block bg-wifa-gold text-wifa-dark px-10 py-5 text-lg rounded-full font-black shadow-[0_10px_25px_rgba(212,175,55,0.3)] hover:-translate-y-1 hover:bg-wifa-gold-hover hover:text-white hover:shadow-[0_15px_30px_rgba(212,175,55,0.5)] transition duration-300 reveal-left" style="transition-delay: 0.3s">
                Jelajahi Paket →
            </a>
        </div>
    </div>

    <div class="section-wave">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 80L50 72C100 64 200 48 300 42C400 36 500 36 600 42C700 48 800 60 900 64C1000 68 1100 60 1150 56L1200 52V80H0Z" fill="white"/>
        </svg>
    </div>
</section>


<!-- Alerts -->
@if(session('success'))
<div class="max-w-7xl mx-auto px-6 py-8 relative z-20">
    <div class="bg-green-50 border border-green-200 p-4 rounded-xl shadow-sm text-center">
        <p class="text-green-700 font-bold">✅ {{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Value Proposition Section (Replaces Stats) -->
<section class="pt-24 pb-12 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10 pb-8">
            <!-- Card 1: Fasilitas Terbaik -->
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-100 relative group hover:-translate-y-2 transition duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.12)] reveal">
                <!-- Icon: Kaaba -->
                <div class="text-wifa-gold mb-8 pb-6 border-b border-gray-100 flex items-center">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <!-- Text -->
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black text-wifa-dark mb-4 tracking-tight">Fasilitas Terbaik</h3>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">Mulai dari akomodasi premium, transportasi modern, sajian halal bergizi, hingga pendamping profesional yang siap mendampingi setiap langkah Anda.</p>
                </div>
            </div>
            
            <!-- Card 2: Pelayanan Prima -->
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-100 relative group hover:-translate-y-2 transition duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.12)] reveal" style="transition-delay: 0.1s">
                <!-- Icon: Mosque/Dome -->
                <div class="text-wifa-gold mb-8 pb-6 border-b border-gray-100 flex items-center">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                </div>
                <!-- Text -->
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black text-wifa-dark mb-4 tracking-tight">Pelayanan Prima</h3>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">Tim profesional kami siap melayani dengan ramah, sigap, dan penuh perhatian, memastikan setiap detail kebutuhan Anda terpenuhi, dengan pendampingan sepenuh hati.</p>
                </div>
            </div>

            <!-- Card 3: Penuh Pemaknaan -->
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-100 relative group hover:-translate-y-2 transition duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.12)] reveal" style="transition-delay: 0.2s">
                <!-- Icon: Book/Quran/Heart -->
                <div class="text-wifa-gold mb-8 pb-6 border-b border-gray-100 flex items-center">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <!-- Text -->
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black text-wifa-dark mb-4 tracking-tight">Penuh Pemaknaan</h3>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed">Bagi Wifa Tour, setiap perjalanan bukan hanya tentang destinasi, tetapi tentang menemukan makna di setiap langkah untuk mendekatkan diri pada-Nya sekaligus memperkaya jiwa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package Grid (Dynamic) -->
<section id="paket" class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-base md:text-lg mb-3 block reveal">Program Pilihan</span>
            <h2 class="text-4xl md:text-6xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Daftar Paket Umroh & Haji</h2>
            <div class="line-accent mx-auto mt-6"></div>
        </div>

        @if($packages->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto reveal-scale">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <p class="text-gray-500 font-medium text-xl">Program keberangkatan sedang diperbarui.</p>
                <p class="text-base text-gray-400 mt-2">Silakan hubungi kami untuk informasi jadwal terdekat.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 stagger-children">
                @foreach($packages as $package)
                    <div class="reveal card-hover">
                        <x-frontend.package-card :package="$package" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us -->
<section id="tentang-kami" class="py-28 bg-white relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-20 -left-20 w-72 h-72 bg-wifa-gold/5 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 -right-20 w-72 h-72 bg-wifa-green/5 rounded-full blur-3xl animate-float-delay"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20 block">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-base md:text-lg mb-3 block reveal">Nilai Perusahaan</span>
            <h2 class="text-4xl md:text-6xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Mengapa Memilih Wifa Tour?</h2>
            <div class="line-accent mx-auto mt-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 stagger-children">
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Terpercaya" desc="Berizin Resmi PPIU No. U.10 Tahun 2021. Pastikan pilih Travel berizin resmi.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                </x-frontend.feature-item>
            </div>
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Aman & Nyaman" desc="Jamaah terlindungi asuransi, fasilitas hotel nyaman dekat dengan Masjidil Haram & Nabawi.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                </x-frontend.feature-item>
            </div>
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Terbaik" desc="Pelayanan terbaik membantu konsultasi dan memenuhi 24 Jam kebutuhan selama di Tanah Suci.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
                </x-frontend.feature-item>
            </div>
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Tour Leader & Muthowif" desc="Selama menjalankan ibadah umroh jamaah akan didampingi tour leader & muthowif profesional.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                </x-frontend.feature-item>
            </div>
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Resmi" desc="Provider Umroh Resmi di Indonesia, Jaminan keberangkatan hindari gagal terbang.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" /></svg>
                </x-frontend.feature-item>
            </div>
            <div class="reveal card-hover">
                <x-frontend.feature-item title="Layanan Ibadah" desc="Membimbing jamaah menjalankan ibadah dengan Khusyuk sesuai Al-Qur'an & Sunnah.">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                </x-frontend.feature-item>
            </div>
        </div>
        
        <div class="mt-24 bg-wifa-green rounded-[2.5rem] p-8 lg:p-16 border-4 border-wifa-green/10 flex flex-col md:flex-row gap-12 items-center shadow-2xl relative overflow-hidden reveal-scale">
            <!-- decorative bg inside -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-wifa-gold/10 rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute -left-10 -top-10 w-60 h-60 bg-wifa-gold/5 rounded-full blur-3xl animate-float"></div>
            
            <div class="md:w-1/2 relative z-10 text-white">
                <span class="text-wifa-gold font-bold tracking-widest uppercase text-sm md:text-base mb-3 block reveal-left">Keunggulan Program</span>
                <h3 class="text-4xl lg:text-5xl font-black mb-8 leading-tight reveal-left" style="transition-delay: 0.1s">Beribadah Lebih Khusyuk Tanpa Beban Fikiran</h3>
                <ul class="space-y-6">
                    <li class="flex items-start reveal-left" style="transition-delay: 0.15s"><div class="w-7 h-7 rounded-full bg-wifa-gold text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div> <span class="text-xl font-medium text-gray-200">Muthawif berpengalaman di Tanah Suci.</span></li>
                    <li class="flex items-start reveal-left" style="transition-delay: 0.2s"><div class="w-7 h-7 rounded-full bg-wifa-gold text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div> <span class="text-xl font-medium text-gray-200">Pesawat Direct Madinah atau Jeddah.</span></li>
                    <li class="flex items-start reveal-left" style="transition-delay: 0.25s"><div class="w-7 h-7 rounded-full bg-wifa-gold text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div> <span class="text-xl font-medium text-gray-200">Hotel dekat dengan Masjid Nabawi dan Masjidil Haram.</span></li>
                    <li class="flex items-start reveal-left" style="transition-delay: 0.3s"><div class="w-7 h-7 rounded-full bg-wifa-gold text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div> <span class="text-xl font-medium text-gray-200">Akses eksklusif Free Lounge sebelum masuk bandara.</span></li>
                    <li class="flex items-start reveal-left" style="transition-delay: 0.35s"><div class="w-7 h-7 rounded-full bg-wifa-gold text-wifa-green flex items-center justify-center shrink-0 mt-0.5 mr-4"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div> <span class="text-xl font-medium text-gray-200">Mendapat album foto kenangan dan menu legendaris Al-Baik saat kepulangan.</span></li>
                </ul>
            </div>
            <div class="md:w-1/2 relative z-10 w-full">
                <!-- Stacked Images Effect -->
                <div class="relative w-full aspect-square md:aspect-auto md:h-[450px] reveal-right" style="transition-delay: 0.2s">
                    <div class="absolute inset-0 bg-wifa-gold rounded-3xl transform rotate-3 scale-95 opacity-50 shimmer-gold"></div>
                    <img src="{{ asset('images/content/pelayanan-umrah.png') }}" class="absolute inset-0 rounded-3xl shadow-2xl w-full h-full object-cover transform -rotate-1 hover:rotate-0 transition duration-500" alt="Pelayanan Umrah Wifa Tour">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Perlengkapan Umroh Banner -->
<section class="py-12 bg-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="rounded-3xl overflow-hidden shadow-2xl transition duration-500 hover:shadow-[0_20px_50px_rgba(27,67,50,0.15)] hover:scale-[1.01] reveal-scale">
            <img src="{{ asset('images/content/perlengkapan.jpg') }}" alt="Perlengkapan Umroh Eksklusif" class="w-full h-auto object-cover">
        </div>
    </div>
</section>

<!-- Mitra Maskapai & Klien -->
<section class="py-16 bg-white overflow-hidden relative border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-6 flex flex-col gap-16 items-center">
        <!-- Airlines -->
        <div class="w-full text-center reveal-scale">
            <img src="{{ asset('images/content/airlines.png') }}" alt="Airlines Partner" class="w-full max-w-4xl mx-auto h-auto drop-shadow-md rounded-2xl hover:scale-105 transition duration-500">
        </div>
        <!-- Clients -->
        <div class="w-full text-center reveal-scale" style="transition-delay: 0.15s">
            <img src="{{ asset('images/content/clients.png') }}" alt="Our Clients" class="w-full max-w-4xl mx-auto h-auto drop-shadow-md rounded-2xl hover:scale-105 transition duration-500">
        </div>
    </div>
</section>

<!-- Wifa Info Section -->
<section id="artikel" class="py-24 bg-white relative border-t border-gray-100 overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-80 h-80 bg-wifa-gold/5 rounded-full blur-3xl animate-float"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-base md:text-lg mb-3 block reveal">Wifa Info</span>
            <h2 class="text-4xl md:text-6xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Informasi Seputar Umroh & Haji</h2>
            <div class="line-accent mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Article 1 -->
            <div x-data="{ expanded: false }" class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-lg transition duration-300 card-hover reveal-left">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-green-100 text-green-700 text-sm font-bold px-4 py-1.5 rounded-full">Haji</span>
                    <span class="text-gray-400 text-base">Edukasi</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-4 transition-all" :class="expanded ? '' : 'line-clamp-2'">Haji Reguler vs Haji Khusus Terpercaya</h3>
                <p class="text-gray-600 text-lg mb-6 leading-relaxed transition-all duration-300" :class="expanded ? '' : 'line-clamp-4'">
                    Haji reguler diurus oleh pemerintah, sedangkan Haji khusus (ONH Plus) diselenggarakan oleh agen travel resmi PPIU. Dengan mendaftar Haji Khusus melalui Wifa Tour, jamaah mendapatkan fasilitas premium (Hotel bintang lima berdekatan dengan Masjidil Haram/Nabawi), serta masa tunggu (antrian) yang cenderung lebih cepat berkisar 5–8 tahun. Selain itu, pendampingan ibadah dari Muthawwif profesional juga jauh lebih intensif sehingga jamaah bisa fokus sepenuhnya pada kekhusyukan ibadah tanpa memikirkan hal-hal teknis di lapangan.
                </p>
                <button @click="expanded = !expanded" class="text-wifa-gold text-lg font-bold inline-flex items-center hover:text-wifa-gold-hover transition group focus:outline-none">
                    <span x-text="expanded ? 'Sembunyikan' : 'Baca Selengkapnya'"></span>
                    <!-- Arrow Right -->
                    <svg x-show="!expanded" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <!-- Arrow Up -->
                    <svg x-show="expanded" style="display: none;" class="w-4 h-4 ml-2 group-hover:-translate-y-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                </button>
            </div>

            <!-- Article 2 -->
            <div x-data="{ expanded: false }" class="bg-gray-50 rounded-3xl p-8 border border-gray-100 hover:shadow-lg transition duration-300 card-hover reveal-right">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Kesehatan</span>
                    <span class="text-gray-400 text-sm">Persiapan</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4 transition-all" :class="expanded ? '' : 'line-clamp-2'">Mengapa Umroh Perlu Vaksin Meningitis?</h3>
                <p class="text-gray-600 mb-6 leading-relaxed transition-all duration-300" :class="expanded ? '' : 'line-clamp-4'">
                    Vaksin meningitis kini menjadi persyaratan wajib bagi jamaah. Hal ini sebagai langkah tanggap dari pemerintah Arab Saudi untuk mencegah penyakit saat berkumpul di satu tempat yang sangat padat. Hal ini memproteksi seluruh jamaah dari risiko penyakit meningitis meningokokus yang sangat menular melalui pernapasan. Selain perlindungan diri, sertifikat vaksin ini (Buku Kuning) akan dicek secara ketat di imigrasi keberangkatan maupun kedatangan demi keselamatan bersama.
                </p>
                <button @click="expanded = !expanded" class="text-wifa-gold font-bold inline-flex items-center hover:text-wifa-gold-hover transition group focus:outline-none">
                    <span x-text="expanded ? 'Sembunyikan' : 'Baca Selengkapnya'"></span>
                    <!-- Arrow Right -->
                    <svg x-show="!expanded" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <!-- Arrow Up -->
                    <svg x-show="expanded" style="display: none;" class="w-4 h-4 ml-2 group-hover:-translate-y-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="galeri" class="py-24 bg-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-sm mb-3 block reveal">Jejak Langkah</span>
            <h2 class="text-3xl md:text-5xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Galeri Perjalanan Jamaah</h2>
            <div class="line-accent mx-auto mt-4"></div>
        </div>
        
        @if($galleries->count() > 0)
        <div x-data="{ lightbox: false, currentImg: '', currentTitle: '' }" class="relative">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
                @foreach($galleries->take(7) as $index => $photo)
                <div class="overflow-hidden rounded-2xl shadow-sm cursor-pointer group {{ $index === 0 ? 'lg:row-span-2' : '' }} reveal"
                     @click="lightbox = true; currentImg = '{{ asset('storage/' . $photo->image_path) }}'; currentTitle = '{{ $photo->title ?? $photo->caption ?? 'Galeri Jamaah Wifa Tour' }}'">
                    <div class="relative {{ $index === 0 ? 'h-full min-h-[300px] lg:min-h-full' : 'aspect-square' }} overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             alt="{{ $photo->title ?? 'Jamaah Wifa Tour' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        @if($photo->caption)
                        <div class="absolute bottom-0 left-0 right-0 p-3 opacity-0 group-hover:opacity-100 transition duration-300 translate-y-2 group-hover:translate-y-0">
                            <p class="text-white text-xs font-medium truncate drop-shadow">{{ $photo->caption }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                @if($galleries->count() > 7)
                <div class="overflow-hidden rounded-2xl cursor-pointer group reveal" 
                     @click="lightbox = true; currentImg = '{{ asset('storage/' . $galleries->skip(7)->first()->image_path) }}'; currentTitle = 'Galeri Jamaah Wifa Tour'">
                    <div class="relative aspect-square bg-wifa-green flex flex-col items-center justify-center text-wifa-gold hover:bg-wifa-hover transition duration-300">
                        <span class="text-4xl font-black mb-1">+{{ $galleries->count() - 7 }}</span>
                        <span class="text-xs lg:text-sm font-bold uppercase tracking-wider">Foto Lainnya</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Lightbox Modal -->
            <div x-show="lightbox" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" style="display: none;" @click.self="lightbox = false" @keydown.escape.window="lightbox = false">
                <button @click="lightbox = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition z-50">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="max-w-4xl w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <img :src="currentImg" :alt="currentTitle" class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
                    <p class="text-white/80 text-center mt-4 font-medium text-sm" x-text="currentTitle"></p>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto reveal-scale">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <p class="text-gray-500 font-medium text-lg">Galeri sedang dipersiapkan.</p>
            <p class="text-sm text-gray-400 mt-2">Dokumentasi perjalanan jamaah akan segera ditampilkan.</p>
        </div>
        @endif
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimoni" class="py-24 bg-white border-t border-gray-100 overflow-hidden relative">
    <!-- Decorative -->
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-wifa-green/5 rounded-full blur-3xl animate-float-delay"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-sm mb-3 block reveal">Buktikan Sendiri</span>
            <h2 class="text-3xl md:text-5xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Apa Kata Jamaah Kami?</h2>
            <div class="line-accent mx-auto mt-4"></div>
        </div>
        
        @if(isset($testimonials) && $testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 stagger-children">
            @foreach($testimonials as $testi)
            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 relative shadow-sm card-hover reveal">
                <div class="text-wifa-gold text-5xl absolute top-6 right-8 opacity-20 font-serif">"</div>
                <div class="flex gap-1 mb-4 text-wifa-gold">
                    @for($i=1; $i<=$testi->rating; $i++)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 mb-6 italic">"{{ $testi->content }}"</p>
                <div class="flex items-center gap-4">
                    @if($testi->image)
                        <img src="{{ asset('storage/' . $testi->image) }}" alt="{{ $testi->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    @else
                        <div class="w-12 h-12 bg-wifa-green rounded-full flex items-center justify-center text-wifa-gold font-bold">
                            {{ substr(trim($testi->name), 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $testi->name }}</h4>
                        @if($testi->role)
                            <p class="text-xs text-gray-400">{{ $testi->role }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-gray-50 rounded-3xl border border-gray-100 max-w-2xl mx-auto">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <p class="text-gray-500 font-medium">Belum ada testimoni.</p>
        </div>
        @endif
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-24 bg-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-wifa-gold font-bold tracking-[0.2em] uppercase text-sm mb-3 block reveal">FAQ</span>
            <h2 class="text-3xl md:text-5xl font-black text-wifa-green tracking-tight reveal" style="transition-delay: 0.1s">Pertanyaan Umum</h2>
            <div class="line-accent mx-auto mt-4"></div>
        </div>
        
        <div class="space-y-4 stagger-children" x-data="{ activeAccordion: null }">
            <!-- FAQ 1 -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 shadow-sm hover:border-wifa-gold/50 reveal">
                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex justify-between items-center text-left p-6 font-bold text-gray-800 hover:text-wifa-green focus:outline-none">
                    <span class="text-lg">Apa saja dokumen untuk mendaftar umroh di Wifa Tour?</span>
                    <svg class="w-6 h-6 transform transition-transform duration-300 text-wifa-gold" :class="{'rotate-180': activeAccordion === 1}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="activeAccordion === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                        Persyaratan utama pendaftaran adalah Paspor asli (minimal masa berlaku 8 bulan dari jadwal keberangkatan), Fotokopi KTP, KK, Buku Nikah (bagi suami istri), pas foto ukuran 4x6 (wajah 80%), dan buku suntik meningitis.
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 shadow-sm hover:border-wifa-gold/50 reveal">
                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex justify-between items-center text-left p-6 font-bold text-gray-800 hover:text-wifa-green focus:outline-none">
                    <span class="text-lg">Apakah harga sudah termasuk tiket pesawat dan penginapan?</span>
                    <svg class="w-6 h-6 transform transition-transform duration-300 text-wifa-gold" :class="{'rotate-180': activeAccordion === 2}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="activeAccordion === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                        Ya, harga paket Umroh kami bersifat <strong>All-in</strong>. Sudah termasuk Tiket Pesawat PP, Visa Umroh, Akomodasi Hotel, Makan 3x Sehari (Full Board), Transportasi bus AC selama di tanah suci, dan jasa Mutawwif.
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 shadow-sm hover:border-wifa-gold/50 reveal">
                <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex justify-between items-center text-left p-6 font-bold text-gray-800 hover:text-wifa-green focus:outline-none">
                    <span class="text-lg">Apakah pendaftaran Haji Khusus (ONH Plus) terjamin aman?</span>
                    <svg class="w-6 h-6 transform transition-transform duration-300 text-wifa-gold" :class="{'rotate-180': activeAccordion === 3}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="activeAccordion === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                        Tentu, Wifa Tour terdaftar resmi sebagai PIHK (Penyelenggara Ibadah Haji Khusus) berlisensi Kemenag RI dengan nomor PIHK 02205018218280003. Jamaah langsung mendapatkan nomor porsi Haji resmi yang terintegrasi di SISKOPATUH.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lead Form (Contact Us) -->
<section id="kontak" class="py-28 bg-gray-50 border-t border-gray-100 overflow-hidden relative">
    <!-- Decorative -->
    <div class="absolute -top-20 -right-20 w-80 h-80 bg-wifa-gold/5 rounded-full blur-3xl animate-float"></div>
    <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-wifa-green/5 rounded-full blur-3xl animate-float-delay"></div>

    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-5xl font-black text-wifa-green mb-6 tracking-tight reveal">Cari Tahu Lebih Lanjut</h2>
        <p class="text-wifa-gray/80 text-lg mb-14 max-w-2xl mx-auto reveal" style="transition-delay: 0.1s">Kami siap menjemput pertanyaan Anda. Tim ahli wifa tour akan merespons melalui WhatsApp maksimal dalam waktu 5 menit.</p>
        
        <form action="{{ route('frontend.leads.store') }}" method="POST" class="bg-white p-10 md:p-14 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 text-left relative overflow-hidden reveal-scale" style="transition-delay: 0.2s">
            @csrf
            
            <!-- Shimmer accent -->
            <div class="absolute top-0 left-0 right-0 h-1 shimmer-gold"></div>
            
            <input type="hidden" name="package_id" value="{{ $packages->first()->id ?? '' }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 px-6 py-4 rounded-2xl focus:ring-4 focus:ring-wifa-gold/20 focus:border-wifa-gold transition outline-none text-gray-800 placeholder-gray-400" placeholder="Tuliskan nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3 ml-1">Nomor WhatsApp Aktif</label>
                    <input type="tel" name="whatsapp" required class="w-full bg-gray-50 border border-gray-200 px-6 py-4 rounded-2xl focus:ring-4 focus:ring-wifa-gold/20 focus:border-wifa-gold transition outline-none text-gray-800 placeholder-gray-400" placeholder="Cth: 0812xxxx">
                </div>
            </div>
            
            <div class="text-center">
                <button type="submit" class="w-full md:w-auto overflow-hidden relative group bg-wifa-green text-white px-14 py-5 rounded-full font-bold shadow-xl hover:-translate-y-1 transition duration-300">
                    <span class="relative z-10 group-hover:text-wifa-gold transition duration-300 text-lg">Kirim Permintaan Konsultasi</span>
                    <div class="absolute inset-0 h-full w-full bg-wifa-hover scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500 ease-out z-0"></div>
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Modal Booking (Pop-up from Package Card) -->
<div x-data="{ open: false, pkgId: '', pkgName: '' }" @open-booking-modal.window="open = true; pkgId = $event.detail.id; pkgName = $event.detail.name;" x-cloak>
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display: none;">
        <!-- Backdrop -->
        <div x-show="open" x-transition.opacity class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" @click="open = false"></div>
        
        <!-- Modal Panel -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             class="bg-white w-full max-w-md rounded-[2rem] overflow-hidden shadow-2xl relative z-10 border border-gray-100">
             
            <div class="bg-wifa-green p-8 text-center relative overflow-hidden">
                <!-- Abstract bg -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-wifa-gold/20 rounded-full blur-2xl"></div>
                
                <h3 class="text-wifa-gold font-bold text-xl uppercase tracking-widest mb-2 relative z-10">Formulir Pendaftaran</h3>
                <p class="text-white font-medium relative z-10" x-text="pkgName"></p>
                
                <button type="button" @click="open = false" class="absolute top-4 right-4 text-white/50 hover:text-white transition w-8 h-8 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 z-20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('frontend.leads.store') }}" method="POST" class="p-8">
                @csrf
                <input type="hidden" name="package_id" x-bind:value="pkgId">
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 px-5 py-3.5 rounded-xl focus:ring-2 focus:ring-wifa-gold focus:border-wifa-gold transition outline-none">
                </div>
                <div class="mb-10">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp Aktif</label>
                    <input type="tel" name="whatsapp" required class="w-full bg-gray-50 border border-gray-200 px-5 py-3.5 rounded-xl focus:ring-2 focus:ring-wifa-gold focus:border-wifa-gold transition outline-none">
                </div>
                <button type="submit" class="w-full bg-wifa-gold text-wifa-dark font-black text-lg py-4 rounded-full shadow-lg hover:bg-wifa-gold-hover hover:text-white hover:shadow-wifa-gold/40 hover:-translate-y-1 transition duration-300">
                    Daftar Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Login Admin -->
<div x-data="{ openLogin: {{ $errors->has('loginError') ? 'true' : 'false' }} }" @open-login-modal.window="openLogin = true" x-cloak>
    <div x-show="openLogin" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display: none;">
        <!-- Backdrop -->
        <div x-show="openLogin" x-transition.opacity class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openLogin = false"></div>
        
        <!-- Modal Panel -->
        <div x-show="openLogin" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             class="bg-white w-full max-w-sm rounded-[2rem] overflow-hidden shadow-2xl relative z-10 border border-gray-100">
             
            <div class="bg-wifa-green p-8 text-center relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-wifa-gold/20 rounded-full blur-2xl"></div>
                <h3 class="text-wifa-gold font-bold text-xl uppercase tracking-widest mb-1 relative z-10">Admin Login</h3>
                <p class="text-white/70 text-xs relative z-10">Secure Access Portal</p>
                
                <button type="button" @click="openLogin = false" class="absolute top-4 right-4 text-white/50 hover:text-white transition w-8 h-8 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 z-20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('login.post') }}" method="POST" class="p-8">
                @csrf
                @if($errors->has('loginError'))
                <div class="mb-4 p-3 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm text-center">
                    {{ $errors->first('loginError') }}
                </div>
                @endif
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Admin</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full bg-gray-50 border border-gray-200 px-5 py-3.5 rounded-xl focus:ring-2 focus:ring-wifa-gold focus:border-wifa-gold transition outline-none" placeholder="admin@wifatour.com">
                </div>
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 px-5 py-3.5 rounded-xl focus:ring-2 focus:ring-wifa-gold focus:border-wifa-gold transition outline-none" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-wifa-gold text-wifa-dark font-black text-lg py-4 rounded-full shadow-lg hover:bg-wifa-gold-hover hover:text-white hover:shadow-wifa-gold/40 hover:-translate-y-1 transition duration-300">
                    Masuk Dasbor
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
