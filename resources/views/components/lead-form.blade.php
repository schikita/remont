@props([
    'formSource' => 'hero',
    'serviceType' => null,
])

<form class="space-y-3" x-data="leadForm({ formSource: @js($formSource), serviceType: @js($serviceType) })" @submit.prevent="submit">
    <input type="text" name="website" x-model="fields.website" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

    <div>
        <label class="mb-1 block text-xs font-medium text-slate-600" for="lf-name-{{ $formSource }}">Имя</label>
        <input id="lf-name-{{ $formSource }}" type="text" x-model="fields.name" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500">
        <template x-if="errors.name"><p class="mt-1 text-xs text-red-600" x-text="errors.name[0]"></p></template>
    </div>
    <div>
        <label class="mb-1 block text-xs font-medium text-slate-600" for="lf-phone-{{ $formSource }}">Телефон</label>
        <input id="lf-phone-{{ $formSource }}" type="tel" x-model="fields.phone" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500">
        <template x-if="errors.phone"><p class="mt-1 text-xs text-red-600" x-text="errors.phone[0]"></p></template>
    </div>
    <div>
        <label class="mb-1 block text-xs font-medium text-slate-600" for="lf-comment-{{ $formSource }}">Комментарий</label>
        <textarea id="lf-comment-{{ $formSource }}" x-model="fields.comment" rows="2" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-600">Срочность</label>
            <select x-model="fields.urgency" class="w-full rounded-xl border border-slate-200 px-2 py-2 text-sm">
                <option value="normal">Обычная</option>
                <option value="today">Сегодня</option>
                <option value="emergency">Авария</option>
            </select>
        </div>
        <div>
            <label class="mb-1 block text-xs font-medium text-slate-600">Район</label>
            <input type="text" x-model="fields.location" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
        </div>
    </div>
    <button type="submit" class="btn-primary w-full" :disabled="sending">
        <span x-show="!sending">Отправить</span>
        <span x-show="sending" x-cloak>Отправка…</span>
    </button>
    <p x-show="ok" x-cloak class="text-sm font-medium text-emerald-700" x-text="message"></p>
    <p x-show="!ok && message" x-cloak class="text-sm text-red-600" x-text="message"></p>
</form>
