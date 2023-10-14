<?php

namespace Test\Unit;

use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\WithLogin;

class TestAliveTest extends TestCase
{
  use WithLogin;

  protected string $uri_test;

  /**
   * Create a new faker instance.
   *
   * @return void
   */

  protected function setUp(): void
  {
    parent::setUp();
    $this->uri_test = '/api/v1/test/';
    $this->login_uri = '/api/v1/auth/login';
    $this->logout_uri = '/api/v1/auth/logout';
    $this->refresh_uri = '/api/v1/auth/refresh';
    $this->me_uri = '/auth/me';
    $this->token = $this->newLoggedAdmin()['token'];
  }

  /**
   * /api/v1/test [GET]
   */
  public function testBasic()
  {
    $this->get($this->uri_test);
    $this->seeStatusCode(200);
    $this->seeJsonStructure(
      [
        'data' =>
        [
          'randomString',
          'control',
        ]
      ]
    );
    $this->assertIsString('data.randomString');
    $this->assertIsString('data.control');
  }

  /**
   * /api/v1/test/{number} [GET]
   */
  public function testBasicWithNumber()
  {
    $number = rand(2, 50);
    $this->get($this->uri_test . $number);
    $this->seeStatusCode(200);
    $this->seeJsonStructure(
      [
        'data' =>
        [
          'randomString',
          'control',
        ]
      ]
    );
    $this->assertIsString('data.randomString');
    $this->assertIsString('data.control');
  }

  /**
   * /api/v1/test/{string} [GET]
   */
  public function testBasicWithString()
  {
    $string = Str::random();
    $this->get($this->uri_test . $string);
    $this->seeStatusCode(400);
  }

  /**
   * /api/v1/test/token [GET]
   */
  public function testWithLogin()
  {
    $token = $this->newLoggedAdmin()['token'];
    $headers = [
      'Authorization' => 'Bearer ' . $token,
    ];
    $this->get($this->uri_test . 'token', $headers);
    $this->seeStatusCode(200);
  }
}
