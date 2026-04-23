@extends('layouts.site')

@section('content')
    @include('landing.partials.header')

    <main>
        <article class="border-b border-slate-200 bg-white" x-data="{ leadModal: false }" @keydown.escape.window="leadModal = false">
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
                    <p class="mt-2 text-slate-600">Оставьте заявку прямо на этой странице — свяжемся в ближайшее время и сориентируем по стоимости.</p>
                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-primary inline-flex px-6 py-3 shadow-lg shadow-brand-700/25" @click="leadModal = true">Оставить заявку</button>
                        <a class="btn-secondary inline-flex px-6 py-3 font-semibold" href="#seo-lead-form">Заполнить форму ниже</a>
                    </div>
                </div>

                <section id="seo-lead-form" class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
                    <h2 class="text-xl font-semibold text-slate-900">Заявка на консультацию</h2>
                    <p class="mt-2 text-sm text-slate-600">Оставьте контакты, перезвоним и подскажем ориентир по цене.</p>
                    <div class="mt-5 max-w-xl">
                        <x-lead-form form-source="seo-page" :service-type="$page->h1" compact />
                    </div>
                </section>
            </div>

            <div
                x-cloak
                x-show="leadModal"
                x-transition.opacity
                class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 p-4"
                @click.self="leadModal = false"
            >
                <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-slate-200">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Оставьте заявку</h3>
                            <p class="mt-1 text-sm text-slate-600">Перезвоним в рабочее время и сориентируем по стоимости.</p>
                        </div>
                        <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800" @click="leadModal = false" aria-label="Закрыть окно">✕</button>
                    </div>
                    <div class="mt-5">
                        <x-lead-form form-source="seo-page-modal" :service-type="$page->h1" compact />
                    </div>
                </div>
            </div>
        </article>
    </main>

    @include('landing.partials.footer')
@endsection
