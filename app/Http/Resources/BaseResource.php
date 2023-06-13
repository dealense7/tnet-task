<?php

declare(strict_types = 1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    public abstract function transformToExternal(): array;

    public function relationships(): array
    {
        return [];
    }

    public function toArray(Request $request): array
    {
        return [
            'id'         => data_get($this->resource, 'id'),
            'type'       => class_basename($this->resource),
            'attributes' => [
                ...$this->transformToExternal(),
            ],
            'relationships' => $this->relationships(),
        ];
    }
}
