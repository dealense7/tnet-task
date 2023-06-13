<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\TeamSaveRequest;
use App\Http\Resources\TeamResource;
use App\Services\AuthServices;
use App\Services\TeamServices;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamController extends ApiController
{
    public function info(
        TeamServices $service,
        AuthServices $authService
    ): JsonResource
    {
        $user = $authService->getUser();
        $team = $service->findByUserId($user->getId());

        return TeamResource::make($team);
    }

    public function update(
        int             $id,
        TeamSaveRequest $request,
        TeamServices    $service
    )
    {
        $data = $request->validated();
        $item = $service->findByIdOrFail($id);
        $item = $service->update($item, $data);

        return TeamResource::make($item);
    }
}
