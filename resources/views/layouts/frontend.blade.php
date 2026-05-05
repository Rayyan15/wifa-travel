<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wifa Tour & Travel') - PT. Prima Tiga Satu</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wifa-green': '#1B4332',
                        'wifa-dark': '#112B20',
                        'wifa-gold': '#D4AF37',
                        'wifa-gold-hover': '#B8952F',
                        'wifa-gray': '#374151'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        /* ===== SCROLL REVEAL ANIMATIONS ===== */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-60px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-left.revealed {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(60px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-right.revealed {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.85);
            transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-scale.revealed {
            opacity: 1;
            transform: scale(1);
        }
        /* Stagger children */
        .stagger-children .reveal:nth-child(1) { transition-delay: 0.05s; }
        .stagger-children .reveal:nth-child(2) { transition-delay: 0.12s; }
        .stagger-children .reveal:nth-child(3) { transition-delay: 0.19s; }
        .stagger-children .reveal:nth-child(4) { transition-delay: 0.26s; }
        .stagger-children .reveal:nth-child(5) { transition-delay: 0.33s; }
        .stagger-children .reveal:nth-child(6) { transition-delay: 0.40s; }
        .stagger-children .reveal:nth-child(7) { transition-delay: 0.47s; }
        .stagger-children .reveal:nth-child(8) { transition-delay: 0.54s; }

        /* ===== FLOATING ANIMATION ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
        .animate-float-delay {
            animation: float 5s ease-in-out 1.5s infinite;
        }

        /* ===== SHIMMER / GLOW ===== */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-gold {
            background: linear-gradient(90deg, transparent, rgba(212,175,55,0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        /* ===== PULSE GLOW ===== */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(212,175,55,0.2); }
            50% { box-shadow: 0 0 40px rgba(212,175,55,0.5); }
        }
        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        /* ===== PARALLAX FOR BACKGROUND ===== */
        .parallax-bg {
            will-change: transform;
            transition: transform 0.1s linear;
        }

        /* ===== GRADIENT TEXT ===== */
        .text-gradient-gold {
            background: linear-gradient(135deg, #D4AF37, #F5D060, #D4AF37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== ROTATING BORDER ===== */
        @keyframes rotate-border {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== SMOOTH NAVBAR ===== */
        .navbar-scrolled {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
        }

        /* ===== TYPEWRITER CURSOR ===== */
        @keyframes blink {
            50% { border-color: transparent; }
        }

        /* ===== COUNTER UP ===== */
        .count-up {
            font-variant-numeric: tabular-nums;
        }

        /* ===== SMOOTH SECTION DIVIDERS ===== */
        .section-wave {
            position: absolute;
            bottom: -2px;
            left: -1px;
            right: -1px;
            width: calc(100% + 2px);
            overflow: hidden;
            line-height: 0;
            z-index: 5;
        }
        .section-wave svg {
            position: relative;
            display: block;
            width: 100%;
            height: 80px;
        }

        /* ===== CARD TILT HOVER ===== */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
        }

        /* ===== LINE ACCENT ANIMATION ===== */
        @keyframes line-grow {
            from { width: 0; }
            to { width: 80px; }
        }
        .line-accent {
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #D4AF37, transparent);
            border-radius: 999px;
        }
        .line-accent.revealed {
            animation: line-grow 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.3s;
        }

        /* ===== IMAGE ZOOM ON SCROLL ===== */
        .zoom-on-scroll {
            transition: transform 8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .zoom-on-scroll.revealed {
            transform: scale(1.08);
        }
    </style>
</head>
<body class="bg-white text-wifa-gray antialiased overflow-x-hidden">
    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[999] bg-wifa-green flex items-center justify-center transition-opacity duration-700">
        <div class="text-center">
            <img src="/images/logo.png" alt="Wifa Tour & Travel" class="h-28 w-auto mx-auto">
        </div>
    </div>

    <!-- Navbar -->
    <nav x-data="{ mobileMenuOpen: false }" id="mainNav" class="bg-white/80 backdrop-blur-xl shadow-sm px-4 md:px-8 py-2 fixed w-full top-0 z-50 transition-all duration-300 border-b border-gray-100/50">
        <div class="max-w-7xl mx-auto flex justify-between items-center relative">
            <div class="flex items-center gap-2">
                <!-- Wifa Tour Logo -->
                <a href="/" class="flex items-center">
                    <img src="/images/logo_cropped.png" alt="Wifa Tour & Travel" class="h-14 w-auto"
                         onerror="this.style.display='none'">
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#paket" class="text-wifa-gray hover:text-wifa-gold-hover font-medium transition cursor-pointer">Pilihan Paket</a>
                <a href="#tentang-kami" class="text-wifa-gray hover:text-wifa-gold-hover font-medium transition cursor-pointer">Tentang Kami</a>
                <a href="#artikel" class="text-wifa-gray hover:text-wifa-gold-hover font-medium transition cursor-pointer">Wifa Info</a>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <button @click="$dispatch('open-login-modal')" class="text-wifa-green font-bold px-4 py-2 hover:text-wifa-gold transition">Login</button>
                <a href="#kontak" class="border-2 border-wifa-gold text-wifa-gold px-6 py-2 rounded-full font-bold hover:bg-wifa-gold hover:text-white transition duration-300 hover:shadow-lg hover:shadow-wifa-gold/20">Hubungi Kami</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-wifa-green hover:text-wifa-gold transition focus:outline-none p-2 -mr-2">
                    <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.away="mobileMenuOpen = false"
             class="absolute top-full left-0 right-0 bg-white border-b border-gray-100 shadow-xl md:hidden" style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#paket" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:text-wifa-gold hover:bg-gray-50 rounded-xl transition">Pilihan Paket</a>
                <a href="#tentang-kami" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:text-wifa-gold hover:bg-gray-50 rounded-xl transition">Tentang Kami</a>
                <a href="#artikel" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:text-wifa-gold hover:bg-gray-50 rounded-xl transition">Wifa Info</a>
                
                <div class="pt-4 mt-2 border-t border-gray-100 flex flex-col gap-3 px-4">
                    <button @click="$dispatch('open-login-modal'); mobileMenuOpen = false" class="w-full text-center px-4 py-3 text-wifa-green font-bold bg-green-50 rounded-xl hover:bg-green-100 transition">Login Admin</button>
                    <a href="#kontak" @click="mobileMenuOpen = false" class="w-full text-center px-4 py-3 bg-wifa-gold text-white font-bold rounded-xl shadow-lg shadow-wifa-gold/20 hover:bg-wifa-gold-hover transition">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-[84px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-wifa-green text-gray-300 py-16 mt-0 border-t-8 border-wifa-gold">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-sm leading-relaxed mb-8">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="/images/logo.png" alt="Wifa Tour & Travel" class="h-20 w-auto brightness-0 invert">
                </div>
                <p class="max-w-xs mb-6 text-gray-400">
                    Sahabat terbaik menuju Baitullah. Aman dan terpercaya untuk keluarga Anda.
                </p>
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/share/15jNfs3wka/?mibextid=wwXIfr" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-wifa-gold hover:bg-wifa-gold hover:text-wifa-green transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                    </a>
                    <a href="https://www.instagram.com/wifatravel/" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-wifa-gold hover:bg-wifa-gold hover:text-wifa-green transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=6281256789531" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-wifa-gold hover:bg-wifa-gold hover:text-wifa-green transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.875-4.426 9.876-9.874 0-5.446-4.426-9.874-9.876-9.874-5.447 0-9.875 4.428-9.876 9.874-.001 1.765.495 3.468 1.441 5l1.047 1.666-1.127 4.12 4.218-1.106 1.64.982zm8.141-8.583c.459-.9 1.517-.9 1.517-.9l.487 1s.296.843-.195 1.745c0 0-.251.528-.847.886-.596.357-1.109.183-1.433-.06-.324-.242-1.503-1.16-2.584-2.241-1.082-1.082-2.001-2.261-2.242-2.585-.243-.324-.417-.837-.06-1.433.357-.597.885-.847.885-.847.9-.492 1.744-.196 1.744-.196l1 .488s0 1.058-.9 1.517z"></path></svg>
                    </a>
                    <a href="https://www.youtube.com/@wifatravel4628" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-wifa-gold hover:bg-wifa-gold hover:text-wifa-green transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.501 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"></path></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold text-base mb-6 uppercase tracking-wider">PT. Prima Tiga Satu</h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-wifa-gold mt-0.5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Izin Resmi Kemenag RI<br>No. PPIU U.10 Tahun 2021<br>PIHK 02205018218280003</span>
                    </li>
                    <li class="mt-4"><a href="https://simpu.kemenag.go.id/home/detail/1376" target="_blank" class="text-wifa-gold font-bold flex items-center hover:text-white transition">🔍 Cek Legalitas Kemenag</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-base mb-6 uppercase tracking-wider">Kantor Pusat</h4>
                <div class="space-y-4">
                    <p class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-wifa-gold shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Gedung Wirausaha Lt. 5,<br>JI. HR. Rasuna Said Kav. C-5,<br>Karet, Setiabudi, Jakarta Selatan.</span>
                    </p>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold text-base mb-6 uppercase tracking-wider">Hubungi Kami</h4>
                <div class="space-y-4">
                    <p class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-wifa-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Senin-Jumat: 08.00 - 17.00<br>Sabtu: 08.00 - 14.00</span>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-wifa-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:02122513531" class="hover:text-wifa-gold transition">021-2251 3531</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 text-center pt-8 text-xs text-wifa-gold/70 border-t border-wifa-gold/10">
            <p>© {{ date('Y') }} PT. Prima Tiga Satu (Wifa Tour & Travel). All rights reserved.</p>
        </div>
    </footer>
    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/send?phone=6281256789531" target="_blank" class="fixed bottom-8 right-8 z-[90] flex items-center gap-4 group">
        <span class="bg-white text-gray-800 px-4 py-2 rounded-xl shadow-lg border border-gray-100 font-bold text-sm translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none hidden md:block">
            Tanya Kami Sekarang!
        </span>
        <div class="bg-[#25D366] text-white p-4 rounded-full shadow-[0_10px_25px_rgba(37,211,102,0.4)] hover:bg-[#1EBE57] hover:scale-110 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center relative">
            <!-- Ping effect -->
            <div class="absolute inset-0 rounded-full bg-[#25D366] blur opacity-50 group-hover:animate-ping"></div>
            <!-- True WA Icon -->
            <svg class="w-8 h-8 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.878-.788-1.471-1.761-1.644-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
        </div>
    </a>

    <!-- Scroll Reveal + Animations Script -->
    <script>
        // Preloader
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => preloader.style.display = 'none', 700);
            }
        });

        // Navbar shrink on scroll
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) {
                nav.classList.add('navbar-scrolled');
            } else {
                nav.classList.remove('navbar-scrolled');
            }
        });

        // Scroll Reveal Observer
        const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .line-accent, .zoom-on-scroll');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealElements.forEach(el => revealObserver.observe(el));

        // Parallax on Scroll
        const parallaxBgs = document.querySelectorAll('.parallax-bg');
        window.addEventListener('scroll', () => {
            parallaxBgs.forEach(bg => {
                const rect = bg.parentElement.getBoundingClientRect();
                const scrolled = rect.top / window.innerHeight;
                bg.style.transform = `translateY(${scrolled * -40}px)`;
            });
        });

        // Counter animation
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-count'), 10);
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(current).toLocaleString('id-ID');
            }, 16);
        }

        const counters = document.querySelectorAll('.count-up');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => counterObserver.observe(c));
    </script>
</body>
</html>
