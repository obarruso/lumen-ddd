<?php

namespace App\Bitres\Auth\Application;

use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Infrastructure\EloquentModels\UserEloquentModel;
use App\Bitres\Auth\Domain\AuthInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuth implements AuthInterface
{
    public function login(array $credentials): string
    {
        $user = UserEloquentModel::query()->where('email', $credentials['email'])->first();
        if (!$user || !$user->is_active) {
            throw new AuthenticationException();
        } elseif (!$token = auth()->attempt($credentials, true)) {
            throw new AuthenticationException();
        }
        return $token;
    }

    public function logout(): void
    {
        /**
         * TODO: Expiring the old token actually does not work; the old token is still valid."
         */
        auth()->logout();
    }

    public function me(): User
    {
        return UserMapper::fromEloquent(auth()->user());
    }

    public function refresh(): string
    {
        /**
         * TODO: Expiring the old token actually does not work; the old token is still valid."
         */
        try {
            // use Tymon\JWTAuth\Facades\JWTAuth as TymonJWTAuth
            // return TymonJWTAuth::parseToken()->refresh();
            return auth()->refresh(true, true);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            throw new AuthenticationException($e->getMessage());
        }
    }
}