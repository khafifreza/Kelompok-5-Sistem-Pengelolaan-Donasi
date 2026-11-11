<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:10000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'target_amount' => ['required', 'integer', 'min:10000', 'max:1000000000000'],
            'status' => ['sometimes', 'required', 'in:active,closed'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Nama program wajib diisi.',
            'title.max' => 'Nama program maksimal 255 karakter.',
            'category.required' => 'Kategori program wajib diisi.',
            'category.max' => 'Kategori maksimal 100 karakter.',
            'description.required' => 'Deskripsi program wajib diisi.',
            'description.max' => 'Deskripsi program maksimal 10.000 karakter.',
            'image.image' => 'Foto program harus berupa file gambar.',
            'image.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 5 MB.',
            'target_amount.required' => 'Target donasi wajib diisi.',
            'target_amount.integer' => 'Target donasi harus berupa angka bulat.',
            'target_amount.min' => 'Target donasi minimal Rp 10.000.',
            'target_amount.max' => 'Target donasi melebihi batas maksimum.',
            'status.in' => 'Status program tidak valid.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'nama program',
            'category' => 'kategori',
            'description' => 'deskripsi program',
            'image' => 'foto sampul',
            'target_amount' => 'target donasi',
            'status' => 'status program',
        ];
    }
}
