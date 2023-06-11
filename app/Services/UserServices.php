<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;

class UserServices
{
    public function __construct(
        private readonly UserRepositoryContract $repository
    )
    {
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    public function findById(int $id): ?User
    {
        return $this->repository->findById($id);
    }
}
