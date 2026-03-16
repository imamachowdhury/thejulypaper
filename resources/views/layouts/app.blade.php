@php 
    use Carbon\Carbon;
    Carbon::setLocale('bn');

    if (!function_exists('toBangla')) {
        function toBangla($number) {
            $search = ['0','1','2','3','4','5','6','7','8','9'];
            $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
            return str_replace($search, $replace, $number);
        }
    }
@endphp
<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'দ্যা জুলাই পেপার - সত্যের সন্ধানে সার্বক্ষণিক')</title>
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
                    <button @click="mobileMenuOpen = true" class="p-2 text-slate-600 hover:text-pa-red transition-colors">
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
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="খুঁজুন..." class="bg-slate-100 border-none rounded-full py-2 px-6 text-sm focus:ring-2 focus:ring-pa-red transition-all w-64">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-pa-red">
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
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="খুঁজুন..." class="w-full bg-slate-100 border-none rounded-xl py-3 px-5 text-sm focus:ring-2 focus:ring-pa-red">
                            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
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
        <footer class="bg-slate-900 pt-20 pb-12 mt-20 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-16">
                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ url('/') }}" class="block mb-6">
                            <span class="text-3xl font-black tracking-tighter text-pa-red">দ্যা জুলাই<span class="text-white">পেপার</span></span>
                        </a>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6">
                            আধুনিক বিশ্বের জন্য স্বতন্ত্র সাংবাদিকতা। জুলাই পেপার (The July Paper) সরবরাহ করে উচ্চমানের অনুসন্ধানী প্রতিবেদন।
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-pa-red mb-6">বিভাগসমূহ</h4>
                        @php 
                            $footerCategories = \App\Models\MenuLink::where('location', 'footer')->where('type', 'category')->orderBy('sort_order')->take(4)->get();
                        @endphp
                        <ul class="space-y-3">
                            @foreach($footerCategories as $menu)
                            <li><a href="{{ $menu->computed_url }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ $menu->label }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-pa-red mb-6">প্রতিষ্ঠান</h4>
                        @php 
                            $footerPages = \App\Models\MenuLink::where('location', 'footer')->where('type', 'page')->orderBy('sort_order')->get();
                        @endphp
                        <ul class="space-y-3">
                            @foreach($footerPages as $menu)
                            <li><a href="{{ $menu->computed_url }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ $menu->label }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-pa-red mb-6">আইনি তথ্য</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">গোপনীয়তা নীতি</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">ব্যবহারের শর্তাবলী</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">কুকি নীতি</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-500 text-xs">
                        &copy; {{ toBangla(date('Y')) }} দ্যা জুলাই পেপার। স্বতন্ত্র সাংবাদিকতা।
                    </p>
                    <div class="flex space-x-6 text-slate-500">
                        <a href="#" class="hover:text-white transition-colors">ফেসবুক</a>
                        <a href="#" class="hover:text-white transition-colors">টুইটার</a>
                        <a href="#" class="hover:text-white transition-colors">ইনস্টাগ্রাম</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
