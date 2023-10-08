<?php

namespace App\Common\Infrastructure\Lumen\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * Define your route model bindings, pattern filters, and other route configuration.
   *
   * @return void
   */
  public function boot()
  {
    $this->app->router = new Router($this->app);

    $this->app->router->group([
      'middleware' => ['web'],
    ], function ($router) {
      require base_path('routes/web.php'); // Default routes
    });
    
    $this->app->router->group([
      'prefix' => 'api',
    ], function ($router) {
      $router->group([
        'prefix' => 'v1',
      ], function ($router) {
        require base_path('src/Test/Presentation/Http/routes.php');
        require base_path('src/Bitres/User/Presentation/Http/routes.php');
        require base_path('src/Bitres/Auth/Presentation/Http/routes.php');
      });
    });
  }
}
