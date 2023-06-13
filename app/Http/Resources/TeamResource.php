<?php

declare(strict_types = 1);

namespace App\Http\Resources;



class TeamResource extends BaseResource
{
    public function transformToExternal(): array
    {
        /** @var \App\Models\Team $team */
        $team = $this;
        return [
            'name'    => $team->getName(),
            'balance' => $team->getFormattedBalance(),
        ];
    }

    public function relationships(): array
    {
        return [
            'players' => PlayerResource::collection($this->whenLoaded('players')),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
