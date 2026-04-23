@php
    use App\Support\MediaUrl;
    use App\Support\SectionGradient;
@endphp

@if($about->is_published)
    <section id="about" class="border-y border-slate-200 py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
        <div class="container-narrow grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <h2 class="section-title">{{ $about->title }}</h2>
                @if($about->subtitle)
                    <p class="mt-2 text-lg font-medium text-brand-800">{{ $about->subtitle }}</p>
                @endif
                <div class="prose prose-slate mt-6 max-w-none">{!! $about->body !!}</div>
                @if(is_array($about->stats))
                    <dl class="mt-8 grid grid-cols-2 gap-4 text-sm">
                        @foreach($about->stats as $label => $value)
                            <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200/80">
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif
            </div>
            <div class="relative">
                @if($about->image_path)
                    <img src="{{ MediaUrl::public($about->image_path) }}" alt="" class="rounded-3xl object-cover shadow-lg ring-1 ring-slate-200/80" loading="lazy" width="640" height="720">
                @else
                    <div class="aspect-[4/5] rounded-3xl bg-gradient-to-br from-brand-100 to-brand-300 p-10 text-slate-900 shadow-inner">
                        <p class="text-lg font-semibold">Профессиональный подход к ремонту ванной и санузла</p>
                        <p class="mt-3 text-sm text-slate-800/80">Точная геометрия, аккуратные примыкания и контроль качества на каждом этапе работ.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
