<?php

declare(strict_types = 1);

namespace App\Http\Resources;


class PlayerResource extends BaseResource
{
    public function transformToExternal(): array
    {
        /** @var \App\Models\Player $player */
        $player = $this;
        return [
            'firstName'   => $player->getFirstName(),
            'lastName'    => $player->getLastName(),
            'age'         => $player->getAge(),
            'marketValue' => $player->getMarketValue(),
            'position'    => $player->getTypeToText(),
        ];
    }

    public function relationships(): array
    {
        return [
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
