<?php

namespace App\Bitres\User\Application\UseCases\Queries;

use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Policies\UserPolicy;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Common\Domain\QueryInterface;

class FindUserByIdQuery implements QueryInterface
{
  private UserRepositoryInterface $repository;

  public function __construct(
    private readonly string $uuid
  ) {
    $this->repository = app()->make(UserRepositoryInterface::class);
  }

  public function handle(): User
  {
    authorize('findByUuid', UserPolicy::class);
    return $this->repository->findByUuid($this->uuid);
  }
}
