@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Top Section: Lead & Headlines -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 border-b pb-12">
        <!-- Lead Content (Column 1-9) -->
        <div class="lg:col-span-9">
            @if($featuredArticles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Lead -->
                <div class="md:col-span-2 group cursor-pointer" onclick="window.location='{{ route('articles.show', $featuredArticles[0]->slug) }}'">
                    <div class="aspect-[16/10] overflow-hidden rounded bg-slate-100 mb-4">
                        @if($featuredArticles[0]->featured_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredArticles[0]->featured_image) }}" alt="{{ $featuredArticles[0]->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400 font-serif font-black text-4xl opacity-10">জুলাই পেপার</div>
                        @endif
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight group-hover:text-pa-red transition-colors mb-3 pa-headline">
                        {{ $featuredArticles[0]->title }}
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base md:text-lg line-clamp-3">
                        {{ $featuredArticles[0]->excerpt }}
                    </p>
                    <div class="mt-4 flex items-center text-xs font-bold text-slate-400 uppercase tracking-tighter">
                        <span class="text-pa-red">{{ $featuredArticles[0]->category->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $featuredArticles[0]->published_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Secondary Grid -->
                <div class="space-y-6">
                    @foreach($featuredArticles->slice(1, 3) as $article)
                    <div class="group cursor-pointer flex flex-col" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                        <div class="aspect-video overflow-hidden rounded bg-slate-100 mb-3">
                            @if($article->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-slate-100"></div>
                            @endif
                        </div>
                        <h2 class="text-lg font-bold leading-snug group-hover:text-pa-red transition-colors pa-headline">
                            {{ $article->title }}
                        </h2>
                        <span class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $article->published_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Restore Latest Section here if it was removed -->
            <div class="mt-12 md:mt-16">
                <div class="flex items-center space-x-2 mb-8 border-b pb-2 border-pa-red inline-block">
                    <span class="w-1.5 h-6 bg-pa-red"></span>
                    <h2 class="text-xl md:text-2xl font-black uppercase tracking-widest">সর্বশেষ সংবাদ</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach($latestArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="group flex flex-row-reverse lg:block gap-4 border-b lg:border-none pb-4 lg:pb-0">
                        <div class="w-1/3 lg:w-full aspect-[16/9] mb-0 lg:mb-4 flex-shrink-0">
                            @if($article->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover rounded-sm group-hover:shadow-md transition-all">
                            @else
                            <div class="w-full h-full bg-slate-50 border flex items-center justify-center text-slate-300 font-serif text-sm opacity-50">জুলাই পেপার</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm md:text-lg font-bold group-hover:text-pa-red transition-colors pa-headline line-clamp-3">
                                {{ $article->title }}
                            </h3>
                            <div class="mt-2 flex items-center text-[9px] font-bold text-slate-400 uppercase tracking-tighter">
                                <span class="text-pa-red mr-2">{{ $article->category->name }}</span>
                                <span>{{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar: Most Read/Latest (Column 10-12) -->
        <div class="lg:col-span-3">
            <div class="lg:border-l lg:pl-8">
                <div class="flex items-center space-x-2 mb-6 border-b pb-2 border-pa-red inline-block">
                    <span class="w-1 h-5 bg-pa-red"></span>
                    <h3 class="text-sm font-black uppercase tracking-widest">সর্বাধিক পঠিত</h3>
                </div>
                @php
                    function toBangla($number) {
                        $search = ['0','1','2','3','4','5','6','7','8','9'];
                        $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                        return str_replace($search, $replace, $number);
                    }
                @endphp
                <div class="space-y-8">
                    @foreach($mostReadArticles as $index => $article)
                    <div class="flex space-x-4 group cursor-pointer" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                        <span class="text-3xl font-black text-slate-200 group-hover:text-pa-red transition-colors italic leading-none">{{ toBangla($index + 1) }}</span>
                        <div>
                            <h4 class="text-sm font-bold leading-tight group-hover:text-pa-red transition-colors">{{ $article->title }}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
                

            </div>
        </div>
    </div>

    <!-- Segment: Category Based Sections -->
    <div class="py-12 space-y-16">
        @foreach($homepageCategories as $category)
        <div class="border-t pt-10 first:border-t-0 first:pt-0">
            <!-- Section Header -->
            <div class="flex items-center space-x-3 mb-10 group cursor-pointer" onclick="window.location='{{ route('category.show', $category->slug) }}'">
                <h3 class="text-2xl md:text-3xl font-black text-slate-900 pa-headline">{{ $category->name }}</h3>
                <svg class="h-6 w-6 text-pa-red group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>

            @php $articles = $category->homepageArticles; @endphp
            @if($articles->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                <!-- Left Column: Items 2, 3, 4 (List) -->
                <div class="space-y-8 order-2 lg:order-1">
                    @foreach($articles->slice(1, 3) as $article)
                    <div class="flex space-x-4 group cursor-pointer border-b md:border-none pb-6 md:pb-0 last:border-0" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                        <div class="flex-1">
                            <h4 class="text-sm md:text-base font-bold leading-snug group-hover:text-pa-red transition-colors pa-headline">{{ $article->title }}</h4>
                            <span class="mt-2 block text-[10px] text-slate-400 font-bold uppercase">{{ $article->published_at ? toBangla($article->published_at->diffForHumans()) : '' }}</span>
                        </div>
                        @if($article->featured_image)
                        <div class="w-20 h-20 md:w-24 md:h-16 flex-shrink-0 rounded-sm bg-slate-100 overflow-hidden">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Center Column: Item 1 (Featured) -->
                <div class="lg:col-span-2 border-none lg:border-x lg:px-10 order-1 lg:order-2">
                    @php $first = $articles->first(); @endphp
                    <div class="group cursor-pointer" onclick="window.location='{{ route('articles.show', $first->slug) }}'">
                        <div class="aspect-[16/10] overflow-hidden rounded-sm bg-slate-100 mb-6">
                            @if($first->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($first->featured_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                        </div>
                        <h4 class="text-2xl md:text-3xl font-black leading-tight group-hover:text-pa-red transition-colors pa-headline">{{ $first->title }}</h4>
                        <p class="mt-4 text-slate-600 text-sm md:text-base line-clamp-3 leading-relaxed">{{ $first->excerpt }}</p>
                        <span class="mt-4 block text-xs text-slate-400 font-bold uppercase">{{ $first->published_at ? toBangla($first->published_at->diffForHumans()) : '' }}</span>
                    </div>
                </div>

                <!-- Right Column: Items 5, 6, 7 (List) -->
                <div class="space-y-8 order-3">
                    @foreach($articles->slice(4, 3) as $article)
                    <div class="flex space-x-4 group cursor-pointer border-b md:border-none pb-6 md:pb-0 last:border-0" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                        <div class="flex-1">
                            <h4 class="text-sm md:text-base font-bold leading-snug group-hover:text-pa-red transition-colors pa-headline">{{ $article->title }}</h4>
                            <span class="mt-2 block text-[10px] text-slate-400 font-bold uppercase">{{ $article->published_at ? toBangla($article->published_at->diffForHumans()) : '' }}</span>
                        </div>
                        @if($article->featured_image)
                        <div class="w-20 h-20 md:w-24 md:h-16 flex-shrink-0 rounded-sm bg-slate-100 overflow-hidden">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
