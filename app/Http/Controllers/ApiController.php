<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function getInputFilters(): array
    {
        return (array) $this->getRequest()->input('filters');
    }

    protected function getInputPage(): int
    {
        return (int) $this->getRequest()->input('page', 1);
    }

    protected function getInputPerPage(): ?int
    {
        $perPage = $this->getRequest()->input('perPage');
        if ($perPage) {
            $perPage = (int) $perPage;
        }

        return $perPage;
    }

    protected function getInputSort(): string
    {
        return (string) $this->getRequest()->input('sort');
    }
}
