<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => preg_replace('/\D/', '', (string) $this->input('amount', '')),
        ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'min:10000', 'max:1000000000'],
            'donor_name' => [$this->user() ? 'nullable' : 'required', 'string', 'max:100'],
            'donor_email' => [$this->user() ? 'nullable' : 'required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
            'is_anonymous' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'Nominal donasi wajib diisi.',
            'amount.integer' => 'Nominal donasi harus berupa angka.',
            'amount.min' => 'Minimal donasi Rp 10.000.',
            'amount.max' => 'Maksimal donasi Rp 1.000.000.000.',
            'donor_name.required' => 'Nama donatur wajib diisi.',
            'donor_name.max' => 'Nama donatur maksimal 100 karakter.',
            'donor_email.required' => 'Email donatur wajib diisi.',
            'donor_email.email' => 'Format email tidak valid.',
            'donor_email.max' => 'Email maksimal 255 karakter.',
            'message.max' => 'Pesan atau doa maksimal 500 karakter.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'amount' => 'nominal donasi',
            'donor_name' => 'nama donatur',
            'donor_email' => 'email donatur',
            'message' => 'pesan atau doa',
            'is_anonymous' => 'status anonim',
        ];
    }
}
