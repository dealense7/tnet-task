<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;

class UserRepository implements UserRepositoryContract
{
    public function create(array $data): User
    {
        $model = $this->getModel();
        return $this->update($model, $data);
    }

    public function update(User $item, array $data): User
    {
        return $item;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getModel()
            ->where('email', $email)
            ->first();
    }

    public function findById(int $id): ?User
    {
        return $this->getModel()
            ->find($id);
    }

    public function getModel(): User
    {
        return new User();
    }
}
