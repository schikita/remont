@php
    use App\Support\SectionGradient;
@endphp
<section id="how" class="py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow">
        <h2 class="section-title">Как мы работаем</h2>
        <p class="section-lead">От заявки до сдачи санузла под ключ — замер, смета со стоимостью ремонта и укладки плитки, работы и акт.</p>
        <ol class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach($workSteps as $i => $step)
                <li class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="text-4xl font-semibold text-brand-100">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $step->title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $step->description }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
