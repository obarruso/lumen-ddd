<?php

namespace App\Bitres\User\Application\UseCases\Commands;

use App\Bitres\User\Domain\Policies\UserPolicy;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Common\Domain\CommandInterface;

class DestroyUserCommand implements CommandInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(
        private readonly string $uuid
    )
    {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function execute(): void
    {
        authorize('delete', UserPolicy::class);
        $this->repository->delete($this->uuid);
    }
}