<?php

namespace App\Bitres\User\Application\Providers;


use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Bitres\User\Domain\Repositories\UserRepositoryInterface::class,
            \App\Bitres\User\Application\Repositories\Eloquent\UserRepository::class
        );
    }
}
