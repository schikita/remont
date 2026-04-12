@php
    use App\Support\MediaUrl;
    use App\Support\SectionGradient;
@endphp

<section id="gallery" class="py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow">
        <h2 class="section-title">Примеры работ</h2>
        <p class="section-lead">Фото с объектов: санузел и ванная под ключ, плитка, швы и готовые интерьеры. Загрузите свои снимки в админке («Галерея»).</p>
        @if($gallery->isEmpty())
            <p class="mt-8 text-sm text-slate-600">Добавьте примеры работ в разделе «Галерея» в админке — они появятся здесь.</p>
        @else
            <div class="mt-12 columns-1 gap-4 sm:columns-2 lg:columns-3">
                @foreach($gallery as $item)
                    <figure class="mb-4 break-inside-avoid overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md shadow-slate-900/5 ring-1 ring-slate-100">
                        <img
                            src="{{ MediaUrl::public($item->image_path) }}"
                            alt="{{ $item->alt_text ?? $item->title }}"
                            class="w-full object-cover"
                            loading="lazy"
                            decoding="async"
                            width="640"
                            height="480"
                        >
                        @if($item->title)
                            <figcaption class="px-3 py-2 text-xs font-medium text-slate-700">{{ $item->title }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        @endif
    </div>
</section>
