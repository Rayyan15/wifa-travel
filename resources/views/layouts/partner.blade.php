<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Partner') — Wifa Travel</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wifa-green': '#1B4332',
                        'wifa-gold': '#D4AF37',
                        'partner-dark': '#1a1a2e',
                        'partner-mid': '#16213e',
                        'partner-accent': '#0f3460',
                        'partner-gold': '#e2b04a',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans antialiased flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-60 bg-gradient-to-b from-[#1B4332] to-[#143325] text-white flex flex-col shadow-xl z-20">
        {{-- Logo --}}
        <div class="h-16 flex items-center justify-start px-4 border-b border-white/10">
            <a href="{{ route('partner.dashboard') }}">
                <img src="/images/logo.png" alt="Wifa Tour & Travel" class="h-10 w-auto brightness-0 invert">
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            @php
                $menus = [
                    ['route' => 'partner.dashboard',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
                    ['route' => 'partner.leads.index', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Leads Saya'],
                    ['route' => 'partner.orders',      'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Pesanan Saya'],
                    ['route' => 'partner.packages.index','icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Daftar Paket'],
                ];
            @endphp
            @foreach($menus as $menu)
                @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
                <a href="{{ route($menu['route']) }}" class="flex items-center px-3 py-2.5 rounded-lg font-medium text-sm transition duration-200 {{ $isActive ? 'bg-wifa-gold text-wifa-green' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/></svg>
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User info + Logout --}}
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-3 px-3 py-2 mb-2 rounded-lg bg-white/5">
                <div class="w-8 h-8 rounded-full bg-wifa-gold flex items-center justify-center text-wifa-green font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-white/40">Komisi {{ auth()->user()->commission_rate }}%</div>
                </div>
            </div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2 rounded-lg text-sm text-white/60 hover:bg-white/10 hover:text-white transition">
                    <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 border-b border-gray-100">
            <div>
                <h2 class="text-lg font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                <div class="text-xs text-gray-400">Portal Partner — Wifa Tour & Travel</div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-100">PARTNER</span>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-xl text-sm font-medium">
                    @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                </div>
            @endif
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <style>
        .animate-fade-in { animation: fadeIn .35s ease-out; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }
    </style>
    @yield('scripts')
</body>
</html>
