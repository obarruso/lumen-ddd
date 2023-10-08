<?php

namespace App\Bitres\User\Application\UseCases\Queries;

use App\Bitres\User\Domain\Model\UserCollection;
use App\Bitres\User\Domain\Policies\UserPolicy;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Common\Domain\QueryInterface;

class FindAllUsersQuery implements QueryInterface
{
    private UserRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function handle(): UserCollection
    {
        authorize('findAll', UserPolicy::class);
        return $this->repository->findAll();
    }
}