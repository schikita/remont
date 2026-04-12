export default () => ({
    loaded: false,
    finished: false,
    questions: [],
    results: [],
    index: 0,
    answers: {},
    resultTitle: '',
    resultDescription: '',
    serviceSlug: null,
    get current() {
        return this.questions[this.index] ?? { question: '', options: [] };
    },
    load() {
        const el = document.getElementById('quiz-data');
        if (!el) {
            return;
        }
        try {
            const data = JSON.parse(el.textContent || '{}');
            this.questions = data.questions || [];
            this.results = data.results || [];
        } catch (e) {
            this.questions = [];
        }
        this.loaded = true;
    },
    async pick(optionId) {
        const q = this.questions[this.index];
        this.answers[q.id] = optionId;
        if (this.index < this.questions.length - 1) {
            this.index++;

            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
        const res = await fetch('/quiz/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': token,
            },
            credentials: 'same-origin',
            body: JSON.stringify({ answers: this.answers }),
        });
        const json = await res.json().catch(() => ({}));
        if (json.ok) {
            this.resultTitle = json.result.title;
            this.resultDescription = json.result.description || '';
            this.serviceSlug = json.result.service?.slug || null;
        } else {
            this.resultTitle = 'Спасибо!';
            this.resultDescription = json.message || 'Попробуйте ещё раз позже.';
            this.serviceSlug = null;
        }
        this.finished = true;
    },
});
