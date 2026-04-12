@php
    use App\Support\SectionGradient;
@endphp
<section id="advantages" class="border-y border-slate-200 py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow">
        <h2 class="section-title">Почему нам доверяют</h2>
        <p class="section-lead">Ремонт санузла под ключ: одна смета с ценой по этапам, договор и контроль качества — без разрозненных бригад.</p>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach($advantages as $item)
                <div class="card">
                    <div class="text-2xl text-brand-700">{{ $item->icon }}</div>
                    <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ $item->title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $item->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
