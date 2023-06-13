<?php

declare(strict_types = 1);

namespace App\Http\Resources;


class CountryResource extends BaseResource
{
    public function transformToExternal(): array
    {
        /** @var \App\Models\Country $country */
        $country = $this;
        return [
            'name' => $country->getName(),
        ];
    }
}
