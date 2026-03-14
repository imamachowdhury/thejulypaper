@extends('layouts.app')

@section('title', 'অনুসন্ধান: ' . $query . ' - দ্যা জুলাই পেপার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Header -->
    <div class="mb-12 border-b-4 border-pa-red pb-4 inline-block">
        <h1 class="text-3xl font-black tracking-tighter">অনুসন্ধান ফলাফল: <span class="text-pa-red">"{{ $query }}"</span></h1>
        <p class="text-slate-500 text-sm mt-2">{{ $articles->total() }}টি ফলাফল পাওয়া গেছে</p>
    </div>

    @if($articles->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles as $article)
        <div class="group border rounded-sm overflow-hidden hover:shadow-lg transition-all bg-white">
            @if($article->featured_image)
            <div class="aspect-video relative overflow-hidden bg-slate-100">
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
            </div>
            @endif
            
            <div class="p-6">
                <div class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-pa-red mb-3">
                    <span>{{ $article->category->name }}</span>
                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                    <span class="text-slate-400">{{ $article->published_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                
                <h3 class="text-xl font-black mb-4 leading-tight group-hover:text-pa-red transition-colors">
                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                </h3>
                
                <p class="text-slate-500 text-sm line-clamp-3 mb-4 leading-relaxed">
                    {{ $article->excerpt }}
                </p>
                
                <div class="flex items-center space-x-3 pt-4 border-t border-slate-50">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-bold uppercase">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <span class="text-[11px] font-black text-slate-900 uppercase tracking-widest">
                        {{ $article->user->name }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $articles->appends(['q' => $query])->links() }}
    </div>
    @else
    <div class="text-center py-20 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200">
        <div class="max-w-md mx-auto">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h2 class="text-xl font-bold text-slate-900 mb-2">দুঃখিত, কোনো ফলাফল পাওয়া যায়নি</h2>
            <p class="text-slate-500 mb-6 text-sm">অনুগ্রহ করে ভিন্ন কিছু কি-ওয়ার্ড দিয়ে পুনরায় চেষ্টা করুন অথবা বানান চেক করুন।</p>
            <form action="{{ route('search') }}" method="GET" class="relative max-w-sm mx-auto">
                <input type="text" name="q" placeholder="পুনরায় খুঁজুন..." class="w-full bg-white border-slate-200 rounded-full py-3 px-6 text-sm focus:ring-2 focus:ring-pa-red focus:border-pa-red transition-all">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-pa-red text-white p-2 rounded-full hover:bg-pa-red/90 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
