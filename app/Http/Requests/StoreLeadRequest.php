<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^[0-9+()\-\s]{6,}$/'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'service_type' => ['nullable', 'string', 'max:120'],
            'urgency' => ['nullable', 'string', 'max:40'],
            'location' => ['nullable', 'string', 'max:255'],
            'form_source' => ['required', 'string', 'max:60'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Укажите корректный номер телефона.',
        ];
    }
}
