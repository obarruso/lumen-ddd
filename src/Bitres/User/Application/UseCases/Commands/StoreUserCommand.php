<?php

namespace App\Bitres\User\Application\UseCases\Commands;

use App\Bitres\User\Application\Exceptions\EmailAlreadyUsedException;
use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Bitres\User\Infrastructure\EloquentModels\UserEloquentModel;
use App\Common\Domain\CommandInterface;
use App\Bitres\User\Application\Exceptions\UuidAlreadyUsedException;
use App\Bitres\User\Domain\Policies\UserPolicy;

class StoreUserCommand implements CommandInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(
        private readonly User $user,
        private readonly Password $password
    ) {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function execute(): User
    {
        authorize('store', UserPolicy::class);
        if (UserEloquentModel::query()->where('uuid', $this->user->uuid)->exists()) {
            throw new UuidAlreadyUsedException();
        }
        
        if (UserEloquentModel::query()->where('email', $this->user->email)->exists()) {
            throw new EmailAlreadyUsedException();
        }

        return $this->repository->store($this->user, $this->password);
    }
}
