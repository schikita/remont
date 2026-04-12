export default function leadForm(config) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    return {
        sending: false,
        ok: false,
        message: '',
        errors: {},
        fields: {
            name: '',
            phone: '',
            comment: '',
            service_type: config.serviceType ?? '',
            urgency: 'normal',
            location: '',
            form_source: config.formSource,
            website: '',
        },
        async submit() {
            this.errors = {};
            this.ok = false;
            this.message = '';
            this.sending = true;

            try {
                const res = await fetch('/leads', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(this.fields),
                });

                const data = await res.json().catch(() => ({}));

                if (res.status === 422 && data.errors) {
                    this.errors = data.errors;
                    return;
                }

                if (! res.ok) {
                    this.message = data.message ?? 'Не удалось отправить заявку.';
                    return;
                }

                this.ok = true;
                this.message = data.message ?? 'Заявка принята.';
                this.fields.name = '';
                this.fields.phone = '';
                this.fields.comment = '';
                this.fields.location = '';
                this.fields.website = '';
            } finally {
                this.sending = false;
            }
        },
    };
}
