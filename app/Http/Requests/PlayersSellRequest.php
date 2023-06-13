<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayersSellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items'            => [
                'required',
                'array',
            ],
            'items.*.playerId' => [
                'required',
                'exists:players,id',
            ],
            'items.*.price'    => [
                'required',
                'numeric',
                'min:0.0001',
            ],
        ];
    }
}
