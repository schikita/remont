@php
    use App\Support\SectionGradient;
@endphp
<section id="faq" class="py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow max-w-3xl">
        <h2 class="section-title">Вопросы и ответы</h2>
        <p class="section-lead">Смета, цена под ключ и сроки — если не нашли ответ, напишите в мессенджер.</p>
        <div class="mt-10 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white">
            @foreach($faq as $item)
                <details class="group px-5 py-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-left font-semibold text-slate-900">
                        {{ $item->question }}
                        <span class="text-slate-400 transition group-open:rotate-45">+</span>
                    </summary>
                    <div class="prose prose-sm prose-slate mt-3 max-w-none">{!! $item->answer !!}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>
