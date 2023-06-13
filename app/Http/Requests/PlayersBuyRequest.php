<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayersBuyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items'              => [
                'required',
                'array',
            ],
            'items.*.transferId' => [
                'required',
                'exists:transfers,id',
            ],
        ];
    }
}
