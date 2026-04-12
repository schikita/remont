@php
    $href = $href ?? route('home');
    $label = $label ?? 'На главную';
    $wrapperClass = $wrapperClass ?? 'mt-5';
@endphp
<p class="{{ $wrapperClass }}">
    <a
        id="back_to_button"
        href="{{ $href }}"
        class="btn-secondary inline-flex items-center gap-2"
    >
        <svg class="h-4 w-4 shrink-0 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        {{ $label }}
    </a>
</p>
