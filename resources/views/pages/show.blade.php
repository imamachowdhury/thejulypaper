@extends('layouts.app')

@section('title', $page->title . ' - দ্যা জুলাই পেপার')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <article class="prose prose-lg max-w-none text-slate-800">
        <h1 class="text-4xl font-black mb-8 pa-headline border-b pb-4">{{ $page->title }}</h1>
        
        <div class="mt-8 leading-relaxed">
            {!! $page->content !!}
        </div>
    </article>
</div>
@endsection
