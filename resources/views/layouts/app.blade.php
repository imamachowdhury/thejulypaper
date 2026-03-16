@php 
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ENJCB65YZW"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ENJCB65YZW');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1.1">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=1.1">

    <title>@yield('title', 'দ্যা জুলাই পেপার - সত্যের সন্ধান ও নিরপেক্ষ খবর')</title>
    <meta name="description" content="@yield('description', 'দ্যা জুলাই পেপার - বাংলার শীর্ষস্থানীয় অনলাইন নিউজ পোর্টাল। সত্যের সন্ধানে আমরা আপনার সাথে সার্বক্ষণিক।')">
    @yield('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
        }
        h1, h2, h3, .pa-headline {
            font-family: 'Hind Siliguri', 'Playfair Display', serif;
        }
        .border-pa-red { border-color: #EE1C24; }
        .bg-pa-red { background-color: #EE1C24; }
        .text-pa-red { color: #EE1C24; }
    </style>
</head>
<body class="antialiased bg-white text-slate-900 selection:bg-pa-red selection:text-white transition-colors duration-300">
    <div class="min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
        <!-- Top Bar -->
        <div class="bg-slate-50 border-b py-2 hidden md:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-pa-red transition-colors">সংস্করণ: বাংলা</a>
                </div>
                <div class="flex space-x-6 items-center">
                    <span>{{ toBangla(Carbon::now()->isoFormat('dddd, D MMMM YYYY')) }}</span>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <header class="bg-white border-b py-3 md:py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <!-- Mobile: Left Hamburger -->
                <div class="flex-1 flex items-center lg:hidden">
                    <button @click="mobileMenuOpen = true" 
                            aria-label="Open Mobile Menu"
                            class="p-2 text-slate-600 hover:text-pa-red transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                
                <!-- Center: Logo -->
                <div class="flex-shrink-0 flex items-center justify-center">
                    <a href="{{ url('/') }}" class="block">
                        <span class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tighter text-pa-red">দ্যা জুলাই<span class="text-slate-900">পেপার</span></span>
                    </a>
                </div>

                <!-- Right: Desktop Search/Login | Mobile Search -->
                <div class="flex-1 flex justify-end items-center space-x-2 md:space-x-4">
                    <form action="{{ route('search') }}" method="GET" class="relative hidden lg:block">
                        <input type="text" name="q" value="{{ request('q') }}" aria-label="Search" placeholder="খুঁজুন..." class="bg-slate-100 border-none rounded-full py-2 px-6 text-sm focus:ring-2 focus:ring-pa-red transition-all w-64">
                        <button type="submit" aria-label="Submit Search" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-pa-red">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Mobile Search & Login Icons -->
                    <div class="flex items-center space-x-1 lg:hidden">
                        <button @click="mobileMenuOpen = true" class="p-2 text-slate-600 hover:text-pa-red">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Desktop Search/Login (Login removed) -->
                    <div class="hidden lg:flex items-center">
                        <!-- Search is already in the form above -->
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Overlay Menu -->
        <div x-show="mobileMenuOpen" 
             class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-md lg:hidden" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false">
            <div class="fixed inset-y-0 left-0 w-[85%] max-w-sm bg-white shadow-2xl flex flex-col" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 @click.stop>
                <div class="p-6 border-b flex items-center justify-between bg-slate-50">
                    <span class="text-xl font-black tracking-tighter text-pa-red">দ্যা জুলাই<span class="text-slate-900">পেপার</span></span>
                    <button @click="mobileMenuOpen = false" class="p-2 text-slate-500 hover:text-pa-red transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-grow overflow-y-auto p-6 scrollbar-hide">
                    <!-- Search inside mobile menu -->
                    <div class="mb-8">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" aria-label="Search Mobile" placeholder="খুঁজুন..." class="w-full bg-slate-100 border-none rounded-xl py-3 px-5 text-sm focus:ring-2 focus:ring-pa-red">
                            <button type="submit" aria-label="Submit Search Mobile" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ url('/') }}" class="bg-slate-50 p-4 rounded-xl text-center border border-transparent hover:border-pa-red transition-all group">
                            <span class="block text-sm font-bold text-slate-900 group-hover:text-pa-red">প্রচ্ছদ</span>
                        </a>
                        @php 
                            $primaryMenus = \App\Models\MenuLink::where('location', 'primary')->orderBy('sort_order')->get();
                        @endphp
                        @foreach($primaryMenus as $menu)
                        <a href="{{ $menu->computed_url }}" class="bg-slate-50 p-4 rounded-xl text-center border border-transparent hover:border-pa-red transition-all group">
                            <span class="block text-sm font-bold text-slate-700 group-hover:text-pa-red pa-headline">{{ $menu->label }}</span>
                        </a>
                        @endforeach
                    </div>

                    <div class="mt-12 pt-8 border-t">
                        <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-6">অন্যান্য</h4>
                        <div class="space-y-4">
                           @php 
                               $footerPages = \App\Models\MenuLink::where('location', 'footer')->where('type', 'page')->orderBy('sort_order')->get();
                           @endphp
                           @foreach($footerPages as $menu)
                           <a href="{{ $menu->computed_url }}" class="block text-sm font-bold text-slate-600 hover:text-pa-red transition-colors">{{ $menu->label }}</a>
                           @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 border-t flex items-center justify-end">
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ toBangla(Carbon::now()->isoFormat('D MMMM YYYY')) }}</p>
                </div>
            </div>
        </div>

        <!-- Sticky Navigation (Desktop) -->
        <nav class="bg-white border-b sticky top-0 z-50 shadow-sm hidden lg:block overflow-hidden h-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex justify-center space-x-10 h-full">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-1 text-sm font-bold relative group {{ request()->is('/') ? 'text-pa-red' : 'text-slate-600' }}">
                        <span>প্রচ্ছদ</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-pa-red transform transition-transform {{ request()->is('/') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                    @foreach($primaryMenus as $menu)
                    @php $isActive = request()->fullUrl() == $menu->computed_url; @endphp
                    <a href="{{ $menu->computed_url }}" class="inline-flex items-center px-1 text-sm font-bold relative group {{ $isActive ? 'text-pa-red' : 'text-slate-600' }} transition-colors">
                        <span class="pa-headline">{{ $menu->label }}</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-pa-red transform transition-transform {{ $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Dynamic Mobile Category Bar (Prothom Alo Style) -->
        <div class="lg:hidden bg-white border-b sticky top-0 z-50 shadow-sm overflow-x-auto whitespace-nowrap scrollbar-hide flex items-center h-12 px-2">
            <a href="{{ url('/') }}" class="inline-block px-4 py-2 mx-1 text-sm font-black rounded-lg {{ request()->is('/') ? 'bg-pa-red text-white' : 'text-slate-900 border border-slate-100 bg-slate-50' }}">প্রচ্ছদ</a>
            @foreach($primaryMenus as $menu)
            @php $isActive = request()->fullUrl() == $menu->computed_url; @endphp
            <a href="{{ $menu->computed_url }}" class="inline-block px-4 py-2 mx-1 text-sm font-bold rounded-lg pa-headline {{ $isActive ? 'bg-pa-red text-white' : 'text-slate-600 border border-slate-50 bg-slate-50/50' }}">{{ $menu->label }}</a>
            @endforeach
            <!-- Add a "spacer" to ensure the last item is swipable past the edge if needed -->
            <div class="pr-6"></div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow bg-white">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-pa-red pt-24 pb-12 mt-32 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Logo -->
                <div class="mb-14 flex justify-center lg:justify-start">
                    <a href="{{ url('/') }}" class="inline-block text-center lg:text-left">
                        <span class="text-4xl md:text-6xl font-black tracking-tighter text-white">দ্যা জুলাই <span class="text-white/80">পেপার</span></span>
                    </a>
                </div>

                <!-- Row 1: Primary Categories -->
                <div class="mb-12">
                    <div class="flex flex-wrap justify-center lg:justify-start items-center gap-y-4 -mx-4">
                        <a href="{{ url('/') }}" class="px-4 text-lg md:text-xl font-bold hover:text-white/80 transition-colors border-r border-white/20 last:border-0 leading-none">প্রচ্ছদ</a>
                        @php 
                            $primaryMenus = \App\Models\MenuLink::where('location', 'primary')->orderBy('sort_order')->get();
                        @endphp
                        @foreach($primaryMenus as $menu)
                            <a href="{{ $menu->computed_url }}" class="px-4 text-lg md:text-xl font-bold hover:text-white/80 transition-colors pa-headline border-r border-white/20 last:border-0 leading-none">{{ $menu->label }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Separator -->
                <hr class="border-white/30 mb-10">

                <!-- Bottom Row -->
                <div class="flex flex-col lg:flex-row justify-between items-center gap-10">
                    <!-- Left: Copyright and Legal -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-x-6 gap-y-4 text-sm md:text-base font-medium text-white">
                        <span class="font-bold">&copy; {{ toBangla(date('Y')) }} দ্যা জুলাই পেপার</span>
                        
                        @php 
                            $footerLinks = \App\Models\MenuLink::where('location', 'footer')->orderBy('sort_order')->get();
                        @endphp
                        @foreach($footerLinks as $link)
                            <a href="{{ $link->computed_url }}" class="hover:underline transition-colors decoration-white/30 underline-offset-4">{{ $link->label }}</a>
                        @endforeach
                    </div>

                    <!-- Right: Social Media -->
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <span class="text-xs font-black uppercase tracking-widest text-white/90">আমাদের অনুসরণ করুন</span>
                        <div class="flex items-center gap-4">
                            <!-- Facebook -->
                            <a href="https://facebook.com" target="_blank" class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-pa-red hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <!-- YouTube -->
                            <a href="https://youtube.com" target="_blank" class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-pa-red hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 4-8 4z"/></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="https://instagram.com" target="_blank" class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-pa-red hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.2-4.358-2.618-6.78-6.98-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
