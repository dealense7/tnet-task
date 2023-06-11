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

    public function tokenStructure(): array
    {
        return $this->token_structure;
    }}
