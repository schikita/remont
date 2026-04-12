@php
    use App\Support\MediaUrl;
    $logo = MediaUrl::public($site->logo_path);
@endphp

<footer id="footer" class="border-t border-slate-200 bg-slate-900 text-slate-100">
    <div class="container-narrow grid gap-10 py-14 md:grid-cols-3">
        <div>
            <div class="flex items-center gap-2 font-semibold">
                @if($logo)
                    <img src="{{ $logo }}" alt="" class="h-8 brightness-0 invert" loading="lazy">
                @else
                    <span class="rounded-lg bg-brand-400/20 px-2 py-1 text-xs text-brand-100">AP</span>
                @endif
                <span>{{ $site->site_name }}</span>
            </div>
            <p class="mt-3 text-sm text-slate-400">{{ $site->footer_note }}</p>
        </div>
        <div>
            <div class="text-sm font-semibold text-white">Документы</div>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                <li><a class="hover:text-white" href="{{ route('policy.show', ['slug' => 'privacy']) }}">Конфиденциальность</a></li>
                <li><a class="hover:text-white" href="{{ route('policy.show', ['slug' => 'terms']) }}">Оферта</a></li>
            </ul>
            <div class="mt-6 text-sm font-semibold text-white">По темам</div>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'remont-sanuzla-pod-klyuch-minsk']) }}">Ремонт санузла под ключ</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'sanuzel-pod-klyuch-minsk']) }}">Санузел под ключ</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'ukladka-plitki-minsk']) }}">Укладка плитки</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'ukladka-plitki-cena-minsk']) }}">Цена укладки плитки</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'remont-sanuzla-s-materialom-minsk']) }}">С материалом</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'stoimost-remonta-sanuzla-minsk']) }}">Стоимость санузла</a></li>
                <li><a class="hover:text-white" href="{{ route('seo.page', ['slug' => 'santehnika-sanuzel-minsk']) }}">Сантехника в санузле</a></li>
            </ul>
        </div>
        <div>
            <div class="text-sm font-semibold text-white">Связь</div>
            @if($contact->phone)
                <p class="mt-3 text-lg font-semibold"><a class="hover:text-brand-200" href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}">{{ $contact->phone }}</a></p>
            @endif
            @if($contact->email)
                <p class="mt-1 text-sm"><a class="text-slate-300 hover:text-white" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
            @endif
            <a class="btn-primary mt-4 inline-flex bg-brand-500 hover:bg-brand-400" href="#hero">{{ $site->footer_cta_label ?? 'Заявка' }}</a>
        </div>
    </div>
    <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
        © {{ date('Y') }} {{ $site->site_name }}
    </div>
</footer>
