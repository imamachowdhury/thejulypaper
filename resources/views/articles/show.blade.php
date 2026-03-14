@extends('layouts.app')

@section('title', $article->title . ' - দ্যা জুলাই পেপার')

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
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-slate-100 border rounded-full flex items-center justify-center font-bold text-pa-red text-sm">
                            {{ substr($article->user->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-800 tracking-tight">{{ $article->user->name }}</span>
                            <span class="block text-xs text-slate-400">ডেস্ক / জুলাই পেপার</span>
                        </div>
                    </div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center space-x-4">
                        <span>আপডেট: {{ \Carbon\Carbon::parse($article->published_at)->isoFormat('LLLL') }}</span>
                    </div>
                </div>
            </div>

            @if($article->featured_image)
            <figure class="mb-8 overflow-hidden rounded shadow-sm">
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-auto">
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
                
                <div class="bg-slate-50 border rounded-xl p-8 flex items-center space-x-6">
                    <div class="h-16 w-16 sm:h-20 sm:w-20 bg-white border-2 border-pa-red rounded-full flex-shrink-0 flex items-center justify-center text-xl sm:text-2xl font-black text-pa-red">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">{{ $article->user->name }} সম্পর্কে</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">
                            {{ $article->user->name }} গত এক দশকেরও বেশি সময় ধরে জাতীয় ও আন্তর্জাতিক সংবাদ কভারেজের সাথে যুক্ত আছেন। 
                        </p>
                    </div>
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
                            <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
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
