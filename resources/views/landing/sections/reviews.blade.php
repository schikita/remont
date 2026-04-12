@php
    use App\Support\SectionGradient;
@endphp
<section id="reviews" class="border-y border-slate-200 py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow">
        <h2 class="section-title">Отзывы</h2>
        <p class="section-lead">Клиенты о ремонте санузла и ванной под ключ, смете и плиточных работах в Минске.</p>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach($reviews as $review)
                <blockquote class="card flex flex-col">
                    <div class="flex items-center gap-1 text-amber-400" aria-label="Оценка {{ $review->rating }} из 5">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <p class="mt-4 flex-1 text-sm text-slate-700">“{{ $review->body }}”</p>
                    <footer class="mt-4 text-sm font-semibold text-slate-900">{{ $review->author }}</footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
