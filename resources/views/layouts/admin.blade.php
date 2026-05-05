<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wifa Tour & Travel - Admin Panel</title>
    <!-- Alpine JS for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wifa-green': '#1B4332',
                        'wifa-gold': '#D4AF37',
                        'wifa-hover': '#143325',
                        'wifa-light': '#F3F4F6'
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#F8FAFC] text-gray-800 font-sans antialiased flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-wifa-green text-white flex flex-col shadow-lg z-20">
        <!-- Logo Area -->
        <div class="h-20 bg-white flex items-center justify-start px-4 border-b border-gray-100">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="/images/logo.png" alt="Wifa Tour & Travel" class="h-16 w-auto">
            </a>
        </div>
        
        <!-- Navigation Container -->
        <nav class="flex-1 py-4 space-y-1 overflow-y-auto px-4 mt-2">
            @php
            $role = auth()->user()->role ?? 'sales';
            $allMenus = [
                // [route, icon_path, label, allowed_roles]
                ['admin.dashboard',    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'Dashboard',          ['superadmin','sales','agen','partner']],
                ['admin.packages.index','M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',                        'Paket',              ['superadmin','agen','partner']],
                ['admin.galleries.index','M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'Galeri',             ['superadmin']],
                ['admin.testimonials.index', 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'Testimoni',          ['superadmin']],
                ['admin.leads.index',   'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Leads',              ['superadmin','sales','agen','partner']],
                ['admin.orders.index',  'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',                   'Data Pemesanan',     ['superadmin','sales','partner']],
                ['admin.manifests.index','M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2', 'Manifest Jamaah',    ['superadmin']],
                ['admin.departures.index','M12 19l9 2-9-18-9 18 9-2zm0 0v-8',                                                          'Operasional',        ['superadmin']],
                ['admin.users.index',   'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'Manajemen User',     ['superadmin']],
            ];
        @endphp

        @foreach($allMenus as [$menuRoute, $menuIcon, $menuLabel, $allowedRoles])
            @if(in_array($role, $allowedRoles))
                @php $isActive = request()->routeIs($menuRoute . '*'); @endphp
                <a href="{{ route($menuRoute) }}" class="flex items-center px-4 py-3 mb-1.5 rounded-lg font-medium transition duration-200 {{ $isActive ? 'bg-wifa-gold text-wifa-green shadow-sm' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ $isActive ? 'text-wifa-green' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menuIcon }}"/></svg>
                    {{ $menuLabel }}
                </a>
            @endif
        @endforeach
        </nav>
        
        <!-- Bottom Action (Logout) -->
        <div class="p-4 mb-4">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 w-full rounded-lg font-medium transition duration-200 text-gray-300 hover:bg-white/10 hover:text-white">
                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#F3F6F9]">
        <!-- Top Navigation -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-8 z-10 border-b border-gray-100">
            <div>
                <h2 class="text-xl font-bold text-gray-800">@yield('title')</h2>
                <div class="text-xs text-gray-500 mt-0.5">Selamat datang, {{ auth()->user()->name ?? 'Wifa Travel' }}</div>
            </div>
            
            <div class="flex items-center gap-5 relative">
                {{-- Role Badge --}}
                @php
                    $roleBadge = match(auth()->user()->role) {
                        'superadmin' => ['label'=>'Super Admin','cls'=>'bg-wifa-green text-wifa-gold'],
                        'sales'      => ['label'=>'Sales','cls'=>'bg-blue-600 text-white'],
                        'agen'       => ['label'=>'Agen','cls'=>'bg-indigo-600 text-white'],
                        'partner'    => ['label'=>'Partner','cls'=>'bg-emerald-600 text-white'],
                        default      => ['label'=>'User','cls'=>'bg-gray-400 text-white'],
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $roleBadge['cls'] }}">{{ $roleBadge['label'] }}</span>
                                
                <!-- Profile Button -->
                <button class="flex items-center gap-2 bg-wifa-green hover:bg-wifa-hover text-wifa-gold px-4 py-1.5 rounded-full font-semibold text-sm transition shadow-sm border border-wifa-green focus:ring-2 focus:ring-wifa-green/50">
                    <svg class="w-5 h-5 opacity-90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    {{ explode(' ', auth()->user()->name ?? 'Administrator')[0] }}
                </button>
            </div>
        </header>

        <!-- Main Content Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl shadow-sm font-medium flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl shadow-sm font-medium" role="alert">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <strong>Terdapat Kesalahan:</strong>
                    </div>
                    <ul class="list-disc list-inside ml-7 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Page Content -->
            <div class="animate-fade-in-up">
                @yield('content')
            </div>
        </main>
        
        <!-- Script Section -->
        @yield('scripts')
    </div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>