@extends('layouts.app')

@section('title', 'বিভাগ: ' . $category->name . ' - দ্যা জুলাই পেপার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Header -->
    <div class="mb-12 border-b-4 border-pa-red pb-4 inline-block">
        <h1 class="text-4xl font-black tracking-tighter">{{ $category->name }}</h1>
    </div>

    @if($articles->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
        <div class="group border rounded-sm overflow-hidden hover:shadow-lg transition-all bg-white">
            @if($article->featured_image)
            <div class="aspect-video relative overflow-hidden bg-slate-100">
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
            </div>
            @endif
            
            <div class="p-6">
                <div class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-pa-red mb-3">
                    <span>{{ $category->name }}</span>
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
        {{ $articles->links() }}
    </div>
    @else
    <div class="text-center py-20 bg-slate-50 rounded-lg">
        <p class="text-slate-500 font-medium">এই বিভাগে বর্তমানে কোনো খবর নেই।</p>
    </div>
    @endif
</div>
@endsection
