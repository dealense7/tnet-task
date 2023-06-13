<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Contracts\Repositories\PlayerRepositoryContract;
use App\Rules\CheckPlayersOwner;
use Illuminate\Foundation\Http\FormRequest;

class PlayersSellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(PlayerRepositoryContract $playerRepository): array
    {
        return [
            'items'            => [
                'required',
                'array',
                new CheckPlayersOwner($playerRepository)
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
