@php
    use App\Support\SectionGradient;
@endphp
<section id="contacts" class="py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}">
    <div class="container-narrow grid gap-10 lg:grid-cols-2">
        <div>
            <h2 class="section-title">Контакты</h2>
            <p class="section-lead">Ремонт санузла под ключ и плиточник на дом — Минск, Минский район, область. Уточним адрес, этаж и удобное время замера.</p>
            <ul class="mt-8 space-y-3 text-sm text-slate-700">
                @if($contact->phone)
                    <li><span class="font-semibold text-slate-900">Телефон:</span> <a class="text-brand-700 hover:underline" href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}">{{ $contact->phone }}</a></li>
                @endif
                @if($contact->email)
                    <li><span class="font-semibold text-slate-900">Email:</span> <a class="text-brand-700 hover:underline" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></li>
                @endif
                @if($contact->address)
                    <li><span class="font-semibold text-slate-900">Адрес:</span> {{ $contact->address }}</li>
                @endif
                @if($contact->work_schedule)
                    <li class="whitespace-pre-line"><span class="font-semibold text-slate-900">График:</span><br>{{ $contact->work_schedule }}</li>
                @endif
            </ul>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($socialLinks as $link)
                    <a class="btn-secondary text-xs" href="{{ $link->url }}" target="_blank" rel="noopener">{{ $link->label }}</a>
                @endforeach
            </div>
        </div>
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900">Заявка</h3>
            <p class="mt-1 text-sm text-slate-600">Укажите удобное время звонка — перезвоним.</p>
            <div class="mt-4">
                <x-lead-form form-source="contacts" />
            </div>
        </div>
    </div>
</section>
