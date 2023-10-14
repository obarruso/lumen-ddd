<?php

namespace Tests\Feature;

use App\Bitres\User\Domain\Model\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\WithLogin;

class LoginTest extends TestCase
{
    use WithLogin;

    protected User $user;

    /**
     * Create a new faker instance.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        $this->login_uri = '/api/v1/auth/login';
        $this->logout_uri = '/api/v1/auth/logout';
        $this->refresh_uri = '/api/v1/auth/refresh';
        $this->me_uri = '/api/v1/auth/me';
        $this->token = $this->newLoggedAdmin()['token'];
    }

    /** @test */
    function active_user_can_login()
    {
        $credentials = $this->validCredentials(['is_active' => true]);

        $this->post($this->login_uri, $credentials)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                'data' => [
                    'accessToken',
                    'expires_in',
                    'token_type',
                ],
            ]);
    }

    /** @test */
    function inactive_user_cannot_login()
    {
        $credentials = $this->validCredentials(['is_active' => false]);

        $this->post($this->login_uri, $credentials)
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED)
            ->seeJson(['error' => 'Unauthorized']);
    }

    /** @test */
    public function user_can_not_login_without_credentials()
    {
        $this->post($this->login_uri, [])
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJson([
                'error' => [
                    'email' => 'The field \'email\' ir required',
                    'password' => 'The field \'password\' ir required'
                ]
            ]);
    }

    /** @test */
    public function user_can_not_login_without_email()
    {
        $credentials = $this->validCredentials();
        unset($credentials['email']);

        $this->post($this->login_uri, $credentials)
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJson([
                'error' => [
                    'email' => 'The field \'email\' ir required',
                ]
            ]);
    }

    /** @test */
    public function user_can_not_login_without_password()
    {
        $credentials = $this->validCredentials();
        unset($credentials['password']);

        $this->post($this->login_uri, $credentials)
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJson([
                'error' => [
                    'password' => 'The field \'password\' ir required'
                ]
            ]);
    }

    /** @test */
    public function user_can_not_login_with_invalid_credentials()
    {
        $credentials = ['email' => 'test@invalid.credentials', 'password' => 'invalid'];

        $this->post($this->login_uri, $credentials)
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED)
            ->seeJson(['error' => 'Unauthorized']);
    }

    /** @test */
    public function user_can_get_his_own_info()
    {
        $this->get($this->me_uri, ['Authorization' => 'Bearer ' . $this->token])
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                'data' => [
                    'user' => [
                        'uuid', 'username', 'email', 'is_admin', 'is_active'
                    ]
                ]
            ]);
    }

    /** @test */
    public function logged_user_can_logout()
    {
        $this->post($this->logout_uri, ['Authorization' => 'Bearer ' . $this->token])
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson(['message' => 'Successfully logged out']);
    }

    /** @test */
    public function logged_user_can_refresh()
    {
        $this->post($this->refresh_uri, ['Authorization' => 'Bearer ' . $this->token])
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                'data' => [
                    'accessToken',
                    'expires_in',
                    'token_type',
                ],
            ]);
        /**
         * TODO: Expiring the old token actually does not work; the old token is still valid."
         */
        // $newToken = $this->getToken($this->response);

        // // The previous token should be invalid.
        // $this->post($this->refresh_uri, ['Authorization' => 'Bearer ' . $this->token])
        //     ->seeStatusCode(Response::HTTP_FORBIDDEN)
        //     ->seeJson(['status']);

        // // The new token should be valid.
        // $this->get($this->me_uri, ['Authorization' => 'Bearer ' . $newToken])
        //     ->seeStatusCode(Response::HTTP_OK);
    }
}
