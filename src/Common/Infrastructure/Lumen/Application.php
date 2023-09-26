<?php

namespace App\Common\Infrastructure\Lumen;

use App\Common\Infrastructure\Lumen\Middleware\JwtMiddleware;
use Laravel\Lumen\Application as BaseApplication;

class Application extends BaseApplication
{
  /*
  |--------------------------------------------------------------------------
  | Register Middleware
  |--------------------------------------------------------------------------
  |
  | Next, we will register the middleware with the application. These can
  | be global middleware that run before and after each request into a
  | route or middleware that'll be assigned to some specific routes.
  |
  */
  protected $middleware = [
    \Illuminate\Session\Middleware\StartSession::class,
    // \App\Common\Infrastructure\Lumen\Middleware\Authenticate::class,
    \App\Common\Infrastructure\Lumen\Middleware\TransformsRequest::class,
    \App\Common\Infrastructure\Lumen\Middleware\TrimStrings::class,
    // \App\Common\Infrastructure\Lumen\Middleware\JwtMiddleware::class,
    // \App\Common\Infrastructure\Lumen\Middleware\VerifyCsrfToken::class,
  ];

  /**
   * The application's route middleware groups.
   *
   * @var array<string, array<int, class-string|string>>
   */
  protected $middlewareGroups = [
    'web' => [
      \Illuminate\Session\Middleware\StartSession::class,
    ],
    'api' => [
      \App\Common\Infrastructure\Lumen\Middleware\Authenticate::class,
      \App\Common\Infrastructure\Lumen\Middleware\TransformsRequest::class,
      \App\Common\Infrastructure\Lumen\Middleware\TrimStrings::class,
      // \App\Common\Infrastructure\Lumen\Middleware\JwtMiddleware::class,
      \App\Common\Infrastructure\Lumen\Middleware\VerifyCsrfToken::class,
    ],
  ];

  protected $routeMiddleware = [
    'web' => \Illuminate\Session\Middleware\StartSession::class,
    'api' => \App\Common\Infrastructure\Lumen\Middleware\Authenticate::class,
  ];

  /**
   * The application's route middleware.
   *
   * These middleware may be assigned to groups or used individually.
   *
   * @var array<string, class-string|string>
   */
  protected $middlewareAliases = [
    'jwt.verify' => JwtMiddleware::class,
    'auth' => \App\Common\Infrastructure\Lumen\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \Src\Common\Infrastructure\Laravel\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
  ];

  /*
  |--------------------------------------------------------------------------
  | Register Service Providers
  |--------------------------------------------------------------------------
  |
  | Here we will register all of the application's service providers which
  | are used to bind services into the container. Service providers are
  | totally optional, so you are not required to uncomment this line.
  |
  */
  /**
   * The loaded service providers.
   *
   * @var array
   */
  protected $providers = [
    /*
     * Laravel Framework Service Providers...
     */
    \Illuminate\Auth\AuthServiceProvider::class,
    \Illuminate\Broadcasting\BroadcastServiceProvider::class,
    \Illuminate\Bus\BusServiceProvider::class,
    \Illuminate\Cache\CacheServiceProvider::class,
    // \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    \Illuminate\Cookie\CookieServiceProvider::class,
    \Illuminate\Database\DatabaseServiceProvider::class,
    \Illuminate\Encryption\EncryptionServiceProvider::class,
    \Illuminate\Filesystem\FilesystemServiceProvider::class,
    // \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    \Illuminate\Hashing\HashServiceProvider::class,
    // \Illuminate\Mail\MailServiceProvider::class,
    // \Illuminate\Notifications\NotificationServiceProvider::class,
    \Illuminate\Pagination\PaginationServiceProvider::class,
    \Illuminate\Pipeline\PipelineServiceProvider::class,
    \Illuminate\Queue\QueueServiceProvider::class,
    // \Illuminate\Redis\RedisServiceProvider::class,
    \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    \Illuminate\Session\SessionServiceProvider::class,
    \Illuminate\Translation\TranslationServiceProvider::class,
    \Illuminate\Validation\ValidationServiceProvider::class,
    \Illuminate\View\ViewServiceProvider::class,
    \Tymon\JWTAuth\Providers\LumenServiceProvider::class,

    /*
     * Common Service Providers...
     */
    \App\Common\Infrastructure\Lumen\Providers\AppServiceProvider::class,
    \App\Common\Infrastructure\Lumen\Providers\RouteServiceProvider::class,

    /*
     * Bitres Service Providers...
     */
    \App\Bitres\User\Application\Providers\UserServiceProvider::class,
    \App\Bitres\Auth\Application\Providers\AuthServiceProvider::class,
  ];


  /**
   * Registres all providers.
   *
   * @return void
   */
  public function loadProviders(): void
  {
    foreach ($this->providers as $provider) {
      $this->register($provider);
    }
  }
}
