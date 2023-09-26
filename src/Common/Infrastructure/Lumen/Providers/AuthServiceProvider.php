<?php

namespace App\Common\Infrastructure\Lumen\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(
          \App\Bitres\Auth\Domain\AuthInterface::class,
          \App\Bitres\Auth\Application\JWTAuth::class,
        );
    }
}
