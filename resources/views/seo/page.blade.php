@extends('layouts.site')

@section('content')
    @include('landing.partials.header')

    <main>
        <article class="border-b border-slate-200 bg-white">
            <div class="container-narrow py-10 sm:py-14">
                <nav class="text-sm text-slate-500" aria-label="Хлебные крошки">
                    <a class="hover:text-brand-700" href="{{ route('home') }}">Главная</a>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-slate-700">Услуги</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-slate-900">{{ $page->h1 }}</span>
                </nav>

                @include('partials.back_to_button')

                <h1 class="mt-6 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $page->h1 }}</h1>

                @if($page->intro)
                    <p class="mt-5 max-w-3xl text-lg text-slate-600">{{ $page->intro }}</p>
                @endif

                <div class="prose-custom mt-10 max-w-none text-slate-700">
                    {!! $page->content !!}
                </div>

                <div class="mt-12 rounded-2xl border border-brand-100 bg-brand-50/50 p-6 sm:p-8">
                    <p class="text-lg font-semibold text-slate-900">Нужен расчёт по вашему объекту?</p>
                    <p class="mt-2 text-slate-600">Оставьте заявку на главной или позвоните — подберём окно выезда в Минске, Минском районе или области.</p>
                    <a class="btn-primary mt-5 inline-flex" href="{{ route('home') }}#hero">Заявка на главной</a>
                </div>
            </div>
        </article>
    </main>

    @include('landing.partials.footer')
@endsection
