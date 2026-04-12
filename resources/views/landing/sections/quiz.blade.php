@php
    use App\Support\SectionGradient;
@endphp
<section
    id="quiz"
    class="border-y border-slate-200 py-20 {{ SectionGradient::sectionClasses($sectionPreset ?? null) }}"
    x-data="quizWizard()"
    x-init="load()"
>
    <div class="container-narrow">
        <h2 class="section-title">Подберём сценарий «под ключ» за минуту</h2>
        <p class="section-lead">Санузел под ключ, плитка с ценой в смете или выезд плиточника — без обязательства заказать.</p>

        <div class="mt-10 grid gap-8 lg:grid-cols-2">
            <div class="card">
                <template x-if="loaded && !finished">
                    <div>
                        <p class="text-sm font-medium text-brand-800" x-text="'Вопрос ' + (index + 1) + ' из ' + questions.length"></p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900" x-text="current.question"></h3>
                        <div class="mt-4 space-y-2">
                            <template x-for="opt in current.options" :key="opt.id">
                                <button
                                    type="button"
                                    class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3 text-left text-sm font-medium text-slate-800 transition hover:border-brand-300 hover:bg-brand-50/60"
                                    @click="pick(opt.id)"
                                >
                                    <span x-text="opt.label"></span>
                                    <span class="text-slate-400">→</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="!loaded">
                    <p class="text-sm text-slate-600">Загрузка квиза…</p>
                </template>
                <template x-if="finished">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-brand-700">Результат</p>
                        <h3 class="mt-2 text-xl font-semibold text-slate-900" x-text="resultTitle"></h3>
                        <p class="mt-3 text-sm text-slate-600" x-text="resultDescription"></p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <a class="btn-primary" href="#hero">Оставить заявку</a>
                            <template x-if="serviceSlug">
                                <a class="btn-secondary" :href="'#service-' + serviceSlug">Смотреть услугу</a>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="card bg-slate-900 text-slate-100">
                <h3 class="text-lg font-semibold">Нужен расчёт по фото?</h3>
                <p class="mt-2 text-sm text-slate-300">Прикрепите снимки в мессенджер — инженер оценит объём и озвучит вилку бюджета.</p>
                <div class="mt-6 space-y-2 text-sm">
                    @if($contact->telegram_url)
                        <a class="block rounded-xl bg-white/10 px-4 py-2 font-medium hover:bg-white/15" href="{{ $contact->telegram_url }}" target="_blank" rel="noopener">Telegram</a>
                    @endif
                    @if($contact->whatsapp_url)
                        <a class="block rounded-xl bg-white/10 px-4 py-2 font-medium hover:bg-white/15" href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener">WhatsApp</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
