@extends('layouts.site')

@push('scripts')
    <script type="application/json" id="quiz-data">@json($quizClient)</script>
@endpush

@section('content')
    @include('landing.partials.header')

    <main>
        @foreach($sections as $section)
            @includeFirst([
                'landing.sections.'.$section,
                'landing.sections._missing',
            ], [
                'section' => $section,
                'sectionPreset' => $sectionSettingsByKey->get($section)?->gradient_preset,
            ])
        @endforeach
    </main>

    @include('landing.partials.footer')
@endsection
