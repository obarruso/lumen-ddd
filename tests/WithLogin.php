<?php

namespace Tests;

use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Domain\Factories\UserFactory;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Str;

trait WithLogin
{
    use DatabaseMigrations;

    protected string $login_uri;
    protected string $logout_uri;
    protected string $refresh_uri;
    protected string $me_uri;
    protected string $token;

    /**
     * Create a new user instance.
     */
    protected function validCredentials(array $attributes = null): array
    {
        $password = Str::random(8);
        $user = UserFactory::new($attributes);
        $userEloquent = UserMapper::toEloquent($user);

        $userEloquent->password = $password;
        $userEloquent->save();

        return [
            'id'         => $userEloquent->id,
            'email'      => $user->email,
            'password'   => $password,
        ];
    }

    protected function newLoggedAdmin(): array
    {
        $credentials = $this->validCredentials(['is_admin' => true]);
        $this->post('/api/v1/auth/login', $credentials);
        return ['token' => $this->getToken($this->response), ...$credentials];
    }

    protected function newLoggedUser(): array
    {
        $credentials = $this->validCredentials(['is_admin' => false]);
        $this->post('/api/v1/auth/login', $credentials);
        return ['token' => $this->getToken($this->response), ...$credentials];
    }

    protected function getToken(TestResponse $response): string
    {
        $arResponse = json_decode($response->getContent(), true);
        return $arResponse['data']['accessToken'];
    }
}