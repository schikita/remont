@php
    use App\Support\MediaUrl;
    $logo = MediaUrl::public($site->logo_path);
@endphp

<header
    class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md"
    x-data="{ open: false }"
>
    <div class="container-narrow flex items-center justify-between gap-4 py-3">
        <a href="{{ route('home') }}#hero" class="flex shrink-0 items-center text-slate-900">
            @if($logo)
                <img src="{{ $logo }}" alt="{{ $site->site_name }}" class="h-9 w-auto" width="120" height="36" loading="eager">
            @else
                <span class="rounded-lg bg-brand-700 px-2 py-1 text-sm font-semibold text-white">AP</span>
            @endif
        </a>

        <nav class="hidden items-center gap-8 text-sm font-medium text-slate-700 lg:flex xl:gap-10">
            <a class="hover:text-brand-700" href="#services">Услуги</a>
            <a class="hover:text-brand-700" href="{{ route('seo.page', ['slug' => 'remont-sanuzla-minsk']) }}">Санузел</a>
            <a class="hover:text-brand-700" href="{{ route('seo.page', ['slug' => 'ukladka-plitki-minsk']) }}">Плитка</a>
            <a class="hover:text-brand-700" href="{{ route('seo.page', ['slug' => 'stoimost-remonta-sanuzla-minsk']) }}">Цены</a>
            <a class="hover:text-brand-700" href="#reviews">Отзывы</a>
            <a class="hover:text-brand-700" href="#contacts">Контакты</a>
        </nav>

        <div class="hidden items-center gap-3 sm:flex">
            @if($contact->telegram_url)
                <a class="btn-secondary px-3 py-2 text-xs" href="{{ $contact->telegram_url }}" target="_blank" rel="noopener">{{ $site->header_messenger_label }}</a>
            @endif
            @if($contact->phone)
                <a
                    href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}"
                    class="group inline-flex items-center gap-8 rounded-2xl border border-slate-200/90 bg-gradient-to-b from-white to-slate-50/90 px-4 py-2.5 shadow-sm shadow-slate-900/5 ring-1 ring-slate-200/60 transition hover:border-brand-200 hover:from-brand-50/40 hover:to-white hover:ring-brand-100 hover:shadow-md"
                >
                    <span class="inline-flex shrink-0 items-center" aria-hidden="true">
                        <img
                            src="{{ asset('phone.png') }}"
                            alt=""
                            width="28"
                            height="28"
                            class="h-7 w-7 rounded-lg object-cover"
                            loading="eager"
                            decoding="async"
                        >
                    </span>
                    <span class="text-sm font-semibold leading-tight tracking-tight text-slate-900 group-hover:text-brand-800 sm:text-base">{{ $contact->phone }}</span>
                </a>
            @endif
        </div>

        <button
            type="button"
            class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-800 lg:hidden"
            @click="open = !open"
            :aria-expanded="open"
            aria-controls="mobile-nav"
        >
            <span class="sr-only">Меню</span>
            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-cloak class="h-6 w-6" x-show="open" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div id="mobile-nav" x-cloak x-show="open" x-transition class="border-t border-slate-200 bg-white lg:hidden">
        <nav class="container-narrow flex flex-col gap-3 py-4 text-sm font-medium">
            <a class="py-1" href="#services" @click="open=false">Услуги</a>
            <a class="py-1" href="{{ route('seo.page', ['slug' => 'remont-sanuzla-minsk']) }}" @click="open=false">Санузел</a>
            <a class="py-1" href="{{ route('seo.page', ['slug' => 'ukladka-plitki-minsk']) }}" @click="open=false">Плитка</a>
            <a class="py-1" href="{{ route('seo.page', ['slug' => 'stoimost-remonta-sanuzla-minsk']) }}" @click="open=false">Цены</a>
            <a class="py-1" href="#reviews" @click="open=false">Отзывы</a>
            <a class="py-1" href="#contacts" @click="open=false">Контакты</a>
            @if($contact->phone)
                <a
                    class="mt-3 inline-flex w-full items-center justify-center gap-6 rounded-2xl border border-slate-200 bg-gradient-to-b from-white to-slate-50 px-4 py-3.5 text-lg font-bold leading-tight text-slate-900 shadow-sm ring-1 ring-slate-200/60"
                    href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}"
                    @click="open=false"
                >
                    <span class="inline-flex shrink-0 items-center" aria-hidden="true">
                        <img
                            src="{{ asset('phone.png') }}"
                            alt=""
                            width="24"
                            height="24"
                            class="h-6 w-6 rounded-md object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                    </span>
                    <span>{{ $contact->phone }}</span>
                </a>
            @endif
        </nav>
    </div>
</header>
