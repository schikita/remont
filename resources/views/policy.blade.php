@extends('layouts.site')

@section('content')
    <main class="py-16">
        <article class="container-narrow prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-brand-700">
            <div class="mb-8 max-w-none">
                @include('partials.back_to_button', ['wrapperClass' => 'mt-0'])
            </div>
            <h1>{{ $page->title }}</h1>
            {!! $page->content !!}
        </article>
    </main>
@endsection
