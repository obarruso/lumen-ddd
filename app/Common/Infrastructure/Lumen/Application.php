<?php

namespace App\Common\Infrastructure\Lumen;

use Laravel\Lumen\Application as BaseApplication;
use Laravel\Lumen\Routing\Router;

class Application extends BaseApplication
{
  protected $middleware = [
    // \App\Common\Infrastructure\Lumen\Middleware\Authenticate::class,
    \App\Common\Infrastructure\Lumen\Middleware\ExampleMiddleware::class,
    \Illuminate\Http\Middleware\HandleCors::class,
  ];

  protected $routeMiddleware = [
    'api' => \App\Common\Infrastructure\Lumen\Middleware\ExampleMiddleware::class,
  ];
  
  /**
   * Bootstrap the router instance.
   *
   * @return void
   */
  public function bootstrapRouter()
  {
    $this->router = new Router($this);
    $this->router->group([
      'middleware' => 'api',
    ], function ($router) {
      require base_path('routes/web.php'); // Default routes
      require base_path('app/Test/Presentation/Http/routes.php');
    });
  }
}
