<?php

declare(strict_types = 1);

namespace App\Models\Traits;

use Illuminate\Validation\ValidationException;

/**
 * @mixin \App\Models\Model
 */
trait Paginatable
{
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    public function getValidPerPage(?int $perPage = null): int
    {
        if (empty($perPage)) {
            return $this->getPerPage();
        }

        if ($perPage > $this->getMaxPerPage()) {
            throw ValidationException::withMessages(['perPage' => 'Limit on per Page: ' . $this->getMaxPerPage()]);
        }

        return $perPage;
    }
}
