<?php

namespace App\Bitres\User\Application\UseCases\Commands;

use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use App\Bitres\User\Domain\Policies\UserPolicy;
use App\Bitres\User\Domain\Repositories\AvatarRepositoryInterface;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Common\Domain\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(
        private readonly User $user,
        private readonly Password $password
    )
    {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function execute(): void
    {
        authorize('update', UserPolicy::class, ['user' => $this->user]);

        $this->repository->update($this->user, $this->password);
    }
}