@php
    use App\Support\MediaUrl;
    use App\Support\SectionGradient;
@endphp

<section id="services" class="py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow">
        <h2 class="section-title">Услуги</h2>
        <p class="section-lead">Ремонт санузла и ванной под ключ в Минске — смета с ценой по этапам до старта. Укладка плитки и плиточные работы, гидроизоляция, демонтаж старой облицовки, отделка санузла, сантехника и инсталляция, ремонт с материалом или по вашему списку. Минск, Минский район и Минская область.</p>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($services as $service)
                <article id="service-{{ $service->slug }}" class="card flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        <div class="text-3xl" aria-hidden="true">{{ $service->icon }}</div>
                        @if($service->price_from)
                            <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-800 ring-1 ring-brand-100">{{ $service->price_from }}</span>
                        @endif
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $service->name }}</h3>
                    <p class="mt-2 flex-1 text-sm text-slate-600">{{ $service->short_description }}</p>
                    @if($service->image_path)
                        <img src="{{ MediaUrl::public($service->image_path) }}" alt="" class="mt-4 h-40 w-full rounded-xl object-cover" loading="lazy" decoding="async">
                    @endif
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                            @if($service->seo_page_slug)
                                <a class="text-sm font-semibold text-brand-700 hover:text-brand-900" href="{{ route('seo.page', ['slug' => $service->seo_page_slug]) }}">{{ $service->cta_label ?? 'Подробнее' }}</a>
                            @endif
                            <a class="text-sm font-semibold text-slate-600 hover:text-brand-800 hover:underline" href="#hero">Заявка</a>
                        </div>
                        @if($contact->phone)
                            <a class="btn-secondary px-3 py-2 text-xs" href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}">Позвонить</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
