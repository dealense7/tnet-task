<?php

declare(strict_types = 1);

namespace App\Libraries\Testing;


trait ProvideDataStructures
{
    private array $token_structure = [
        'type',
        'id',
        'attributes' => [
            'token',
        ],
    ];

    private array $user_structure = [
        'type',
        'id',
        'attributes' => [
            'name',
            'email',
        ],
    ];

    public function tokenStructure(): array
    {
        return $this->token_structure;
    }

    public function userStructure(): array
    {
        return $this->user_structure;
    }
}
