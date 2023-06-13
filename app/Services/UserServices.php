<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\DataTransferObjects\UserDto;
use App\Models\User;

class UserServices
{
    public function __construct(
        private readonly UserRepositoryContract $repository,
        private readonly TeamServices           $teamService
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

    public function create(array $data): User
    {
        $dto = UserDto::toInternal($data);
        $user = $this->repository->create($dto);

        $this->teamService->generateTeam($user);

        return $user;
    }
}
