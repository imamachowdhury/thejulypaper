@extends('layouts.app')

@section('title', $article->title . ' - দ্যা জুলাই পেপার')

@section('meta')
    <meta name="description" content="{{ $article->excerpt }}">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:type" content="article">
    @if($article->featured_image)
    <meta property="og:image" content="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $article->excerpt }}">
    @if($article->featured_image)
    <meta name="twitter:image" content="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}">
    @endif
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Main Article Content (Column 1-8) -->
        <article class="lg:col-span-8">
            <div class="mb-8">
                <div class="flex items-center space-x-2 text-xs font-black uppercase tracking-tighter text-pa-red mb-4">
                    <a href="{{ route('category.show', $article->category->slug) }}" class="hover:underline">{{ $article->category->name }}</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-400">খবর</span>
                </div>
                
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-black leading-[1.2] text-slate-900 pa-headline mb-6">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between border-y py-4 gap-4">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center space-x-4">
                        <span>আপডেট: {{ \Carbon\Carbon::parse($article->published_at)->isoFormat('LLLL') }}</span>
                    </div>
                    
                    <!-- Social Share -->
                    <div class="flex items-center space-x-3">
                        <span class="text-[10px] font-black uppercase text-slate-400 mr-2 tracking-widest hidden sm:block">শেয়ার করুন:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#1877F2] hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#000000] hover:text-white transition-all shadow-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->fullUrl()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#25D366] hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}').then(() => alert('লিঙ্ক কপি হয়েছে!'))" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-800 hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            @if($article->featured_image)
            <figure class="mb-8 overflow-hidden rounded shadow-sm">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-auto">
            </figure>
            @endif

            <div class="prose prose-lg max-w-none text-slate-800 prose-pa-red">
                {!! $article->content !!}
            </div>

            <!-- Author & Tags -->
            <div class="mt-12 pt-8 border-t">
                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($article->tags as $tag)
                    <a href="#" class="px-3 py-1 bg-slate-50 text-slate-500 text-xs font-bold rounded border hover:bg-slate-100 transition-colors capitalize">#{{ $tag->name }}</a>
                    @endforeach
                </div>
                
            </div>
        </article>

        <!-- Article Sidebar (Column 9-12) -->
        <aside class="lg:col-span-4 space-y-12">
            <div class="sticky top-24">
                <div class="flex items-center space-x-2 mb-6 border-b pb-2 border-pa-red inline-block">
                    <span class="w-1 h-5 bg-pa-red"></span>
                    <h3 class="text-sm font-black uppercase tracking-widest">{{ $article->category->name }} বিভাগ থেকে আরও</h3>
                </div>
                
                <div class="space-y-6">
                    @foreach($relatedArticles as $related)
                    <div class="group cursor-pointer flex space-x-4 border-b pb-4 last:border-0" onclick="window.location='{{ route('articles.show', $related->slug) }}'">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold leading-snug group-hover:text-pa-red transition-colors">{{ $related->title }}</h4>
                            <span class="text-[10px] text-slate-400 font-bold uppercase mt-2 block">{{ $related->published_at->diffForHumans() }}</span>
                        </div>
                        @if($related->featured_image)
                        <div class="w-16 h-16 bg-slate-100 rounded flex-shrink-0 overflow-hidden">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="w-16 h-16 bg-slate-100 rounded flex-shrink-0"></div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-12 bg-slate-900 rounded-xl p-6 text-white text-center">
                    <span class="block text-[10px] font-bold text-white/40 uppercase mb-4 tracking-widest">নিউজলেটার</span>
                    <h4 class="text-xl font-black mb-4 pa-headline">সংবাদের সাথেই থাকুন</h4>
                    <p class="text-white/60 text-xs mb-6 px-4">প্রতিদিনের শীর্ষ খবরগুলো সরাসরি আপনার ইনবক্সে পেতে সাবস্ক্রাইব করুন।</p>
                    <div class="flex items-stretch">
                        <input type="email" placeholder="আপনার ইমেইল" class="flex-1 bg-white/10 border-none rounded-l-lg px-4 text-xs focus:ring-1 focus:ring-pa-red">
                        <button class="bg-pa-red px-4 font-bold text-xs rounded-r-lg hover:bg-red-700 transition-colors uppercase">যোগ দিন</button>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
