<?php

namespace App\Libraries\Testing;

use App\Models\User;
use Illuminate\Support\Collection;

trait ProvideDataStructures
{
    public function tokenStructure(): array
    {
        return $this->token_structure;
    }

    private array $token_structure = [
        'type',
        'id',
        'attributes' => [
            'token'
        ],
    ];}
