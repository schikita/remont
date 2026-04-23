@php
    use App\Support\MediaUrl;
    use App\Support\SectionGradient;
    $heroBg = SectionGradient::heroBaseClasses($hero->gradient_preset ?? null);
@endphp
<section id="hero" class="relative overflow-hidden {{ $heroBg }}">
    @if($hero->background_image_path)
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <img
                src="{{ MediaUrl::public($hero->background_image_path) }}"
                alt=""
                class="h-full w-full object-cover opacity-45 sm:opacity-50"
                loading="eager"
                decoding="async"
            >
            <div class="absolute inset-0 bg-gradient-to-br from-white/85 via-brand-50/70 to-brand-100/55"></div>
        </div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-1/2 bg-[radial-gradient(circle_at_top,_rgba(20,184,166,0.38),_transparent_58%)]"></div>
    @else
        <div class="pointer-events-none absolute inset-y-0 right-0 w-1/2 bg-[radial-gradient(circle_at_top,_rgba(20,184,166,0.42),_transparent_58%)]"></div>
    @endif
    <div class="container-narrow relative grid gap-12 pt-4 pb-16 lg:grid-cols-2 lg:items-center lg:py-24">
        <div>
            @if($contact->phone)
                <div class="flex justify-center lg:hidden">
                    <a
                        href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}"
                        style="margin-top: 30px; margin-bottom: 30px;"
                        class="inline-flex items-center gap-2 rounded-xl border border-brand-200 bg-white/90 px-4 py-2 text-lg font-bold text-brand-800 shadow-sm ring-1 ring-brand-100"
                    >
                        <span aria-hidden="true">📞</span>
                        <span>{{ $contact->phone }}</span>
                    </a>
                </div>
            @endif
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-700">Ремонт санузла и ванной под ключ · Минск, Минский район, область</p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">{{ $hero->headline }}</h1>
            @if($hero->subheadline)
                <p class="mt-4 text-lg text-slate-600">{{ $hero->subheadline }}</p>
            @endif
            @if($hero->offer_text)
                <p class="mt-4 rounded-2xl border border-brand-100 bg-white/80 p-4 text-sm text-slate-700 shadow-sm">{{ $hero->offer_text }}</p>
            @endif
            <div class="mt-6 flex flex-wrap gap-3 text-sm">
                @if($hero->urgency_label)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 font-medium text-slate-800 shadow-sm ring-1 ring-slate-200/80">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>{{ $hero->urgency_label }}
                    </span>
                @endif
                @if($hero->guarantee_label)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 font-medium text-slate-800 shadow-sm ring-1 ring-slate-200/80">
                        <span class="h-2 w-2 rounded-full bg-brand-500"></span>{{ $hero->guarantee_label }}
                    </span>
                @endif
            </div>
            @if(is_array($hero->trust_badges) && count($hero->trust_badges))
                <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                    @foreach($hero->trust_badges as $badge)
                        <li class="flex items-start gap-2 text-sm text-slate-700">
                            <span class="mt-0.5 inline-flex h-5 w-5 flex-none items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-800">✓</span>
                            <span>{{ $badge }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
        @if($hero->show_lead_form)
            <div class="card relative">
                <h2 class="text-lg font-semibold text-slate-900">Быстрая заявка</h2>
                <p class="mt-1 text-sm text-slate-600">Перезвоним за 10–15 минут в рабочее время.</p>
                <div class="mt-4">
                    <x-lead-form form-source="hero" />
                </div>
            </div>
        @endif
    </div>
</section>
