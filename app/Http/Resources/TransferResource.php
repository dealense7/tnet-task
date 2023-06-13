<?php

declare(strict_types = 1);

namespace App\Http\Resources;


class TransferResource extends BaseResource
{
    public function transformToExternal(): array
    {
        /** @var \App\Models\Transfer $transfer */
        $transfer = $this;
        return [
            'price' => $transfer->getFormattedPrice(),
            'type'  => $transfer->getTypeToText(),
        ];
    }

    public function relationships(): array
    {
        return [
            'player' => PlayerResource::make($this->whenLoaded('player')),
        ];
    }
}
