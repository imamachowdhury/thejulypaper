@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Top Section: Featured News Grid -->
    @if($featuredArticles->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 border-b pb-12">
        
        <!-- Column 1: Lead + 2 Sub (Col 1-5) -->
        <div class="lg:col-span-5 space-y-10">
            <!-- Lead Article -->
            <div class="group cursor-pointer" onclick="window.location='{{ route('articles.show', $featuredArticles[0]->slug) }}'">
                @if($featuredArticles[0]->featured_image)
                <div class="aspect-[16/10] overflow-hidden rounded bg-slate-100 mb-5 relative">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($featuredArticles[0]->featured_image) }}" alt="{{ $featuredArticles[0]->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                @endif
                <div class="space-y-3">
                    <span class="text-pa-red font-black text-xs uppercase">{{ $featuredArticles[0]->category->name }}</span>
                    <h1 class="text-2xl md:text-3xl font-black leading-tight group-hover:text-pa-red transition-colors pa-headline">
                        {{ $featuredArticles[0]->title }}
                    </h1>
                    <p class="text-slate-600 text-base line-clamp-3 leading-relaxed">
                        {{ $featuredArticles[0]->excerpt }}
                    </p>
                </div>
            </div>

            <!-- Sub Articles (2 Grid) -->
            <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                @foreach($featuredArticles->slice(1, 2) as $article)
                <div class="space-y-3 group cursor-pointer" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                    <h3 class="text-base font-black leading-snug group-hover:text-pa-red transition-colors pa-headline">
                        {{ $article->title }}
                    </h3>
                    <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed">
                        {{ $article->excerpt }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Column 2: 2 Stacked Medium (Col 6-9) -->
        <div class="lg:col-span-4 lg:border-l lg:pl-10 space-y-10 border-t lg:border-t-0 pt-10 lg:pt-0">
            @foreach($featuredArticles->slice(3, 2) as $article)
            <div class="group cursor-pointer space-y-4" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                @if($article->featured_image)
                <div class="aspect-video overflow-hidden rounded bg-slate-100">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="space-y-3">
                    <h2 class="text-xl font-black leading-tight group-hover:text-pa-red transition-colors pa-headline">
                        {{ $article->title }}
                    </h2>
                    <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed">
                        {{ $article->excerpt }}
                    </p>
                </div>
            </div>
            @if(!$loop->last) <hr class="border-slate-100"> @endif
            @endforeach
        </div>

        <!-- Column 3: Sidebar List with Right Micro-Thumbnails (Col 10-12) -->
        <div class="lg:col-span-3 lg:border-l lg:pl-10 border-t lg:border-t-0 pt-10 lg:pt-0">
            <div class="space-y-6">
                @foreach($featuredArticles->slice(5, 6) as $article)
                <div class="flex items-start gap-4 group cursor-pointer border-b border-slate-50 pb-6 last:border-0" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
                    <div class="flex-1">
                        <h4 class="text-[13px] font-bold leading-tight group-hover:text-pa-red transition-colors">
                            {{ $article->title }}
                        </h4>
                    </div>
                    @if($article->featured_image)
                    <div class="w-20 h-14 flex-shrink-0 bg-slate-100 overflow-hidden rounded-sm">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    @else
                    <div class="w-20 h-14 bg-slate-50 rounded-sm"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Circular Bottom Row -->
    @php 
        $rowArticles = $featuredArticles->slice(11, 4);
        if ($rowArticles->count() < 4) {
            $alreadyUsedIds = $featuredArticles->pluck('id')->toArray();
            $fillCount = 4 - $rowArticles->count();
            $fillers = \App\Models\Article::where('status', 'published')
                ->whereNotIn('id', $alreadyUsedIds)
                ->latest('published_at')
                ->take($fillCount)
                ->get();
            $rowArticles = $rowArticles->concat($fillers);
        }
    @endphp

    @if($rowArticles->isNotEmpty())
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-b pb-12 pt-12">
        @foreach($rowArticles as $article)
        <div class="group cursor-pointer space-y-5" onclick="window.location='{{ route('articles.show', $article->slug) }}'">
            <div class="flex justify-center flex-shrink-0">
                <div class="w-28 h-28 md:w-36 md:h-36 rounded-full overflow-hidden border-2 border-pa-red/10 p-1 group-hover:border-pa-red transition-all duration-500">
                    @if($article->featured_image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" class="w-full h-full object-cover rounded-full">
                    @else
                    <div class="w-full h-full bg-slate-100 rounded-full"></div>
                    @endif
                </div>
            </div>
            <div class="text-center space-y-2">
                <span class="text-pa-red font-black text-[10px] uppercase">{{ $article->category->name }}</span>
                <h3 class="text-sm md:text-base font-black leading-tight group-hover:text-pa-red transition-colors pa-headline px-2">
                    {{ $article->title }}
                </h3>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endif


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
    <!-- Segment: Opinion (মতামত) Section -->
    @if($opinionCategory && $opinionArticles->isNotEmpty())
    <div class="py-12 border-t mt-12">
        <div class="max-w-7xl mx-auto">
            <!-- Collection Header -->
            <div class="mb-10 bottom-space">
                <h2 class="mN6fk text-3xl font-black pa-headline">
                    <a href="{{ route('category.show', $opinionCategory->slug) }}" class="flex items-center space-x-1 group">
                        <span class="text-slate-900 group-hover:text-pa-red transition-colors">{{ $opinionCategory->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="32" width="32" class="text-pa-red group-hover:translate-x-1 transition-transform">
                            <path fill="currentColor" d="M9.224,17.776c-0.14-0.175-0.214-0.368-0.223-0.578c-0.009-0.21,0.066-0.394,0.223-0.551l4.621-4.621 L9.198,7.379c-0.14-0.14-0.206-0.328-0.197-0.564S9.084,6.39,9.224,6.25c0.175-0.175,0.363-0.258,0.564-0.249 c0.201,0.009,0.381,0.092,0.538,0.249l5.225,5.225c0.087,0.087,0.149,0.175,0.184,0.262s0.052,0.184,0.052,0.289 c0,0.105-0.017,0.201-0.052,0.289c-0.035,0.088-0.096,0.175-0.184,0.263l-5.199,5.199c-0.157,0.158-0.341,0.232-0.551,0.223 C9.592,17.991,9.399,17.916,9.224,17.776z"></path>
                        </svg>
                    </a>
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left Column (organism1) -->
                @php $pLead = $opinionArticles->first(); @endphp
                <div class="lg:col-span-5 flex flex-col h-full">
                    <div class="organism1 flex-1">
                        <div class="card-with-image-zoom mb-6">
                            <h3 class="headline-title text-2xl md:text-3xl font-black pa-headline leading-relaxed">
                                <a href="{{ route('articles.show', $pLead->slug) }}" class="title-link">
                                    <span class="opinion-highlighter">
                                        <span class="opinion-sub-title">মতামত •</span>{{ $pLead->title }}
                                    </span>
                                </a>
                            </h3>
                        </div>
                        <a href="{{ route('articles.show', $pLead->slug) }}" class="excerpt text-slate-600 md:text-lg leading-relaxed mb-10 block line-clamp-4">
                            {{ $pLead->excerpt }}
                        </a>
                        
                        <div class="mt-auto pt-6">
                            <div class="author-details flex items-center space-x-2 text-sm">
                                <span class="contributor-name font-bold text-slate-400">লেখা:</span>
                                <span class="author-location font-black text-slate-800">{{ $pLead->user->name ?? 'জুলাই পেপার ডেস্ক' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (organism2) -->
                <div class="lg:col-span-7 flex flex-col space-y-10 lg:pl-12 lg:border-l border-slate-100">
                    <div class="organism2 space-y-10">
                        @foreach($opinionArticles->slice(1) as $article)
                        <div class="opinion-story-card flex items-center space-x-6 group border-b border-slate-100/50 pb-8 last:border-0 last:pb-0">
                            <!-- Image/Thumbnail -->
                            <div class="flex-shrink-0">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border border-slate-200 p-0.5 group-hover:border-pa-red transition-all duration-300">
                                        @if($article->featured_image)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" class="w-full h-full object-cover rounded-full">
                                        @else
                                            <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <!-- Text Content -->
                            <div class="story-details flex-1">
                                <h3 class="headline-title text-xl md:text-2xl font-black leading-tight pa-headline text-slate-900 group-hover:text-pa-red transition-colors mb-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="title-link">
                                        <span class="tilte-no-link-parent"><span class="text-pa-red mr-1">মতামত •</span> {{ $article->title }}</span>
                                    </a>
                                </h3>
                                <div class="MdYVB flex items-center space-x-3 text-sm text-slate-500">
                                    <span class="contributor-name font-bold text-slate-800">{{ $article->user->name ?? 'জুলাই পেপার ডেস্ক' }}</span>
                                    @if($article->published_at)
                                    <span class="text-slate-300">•</span>
                                    <span class="font-bold text-[11px] uppercase tracking-wide">{{ toBangla($article->published_at->diffForHumans()) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
