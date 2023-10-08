<?php

$router->group([
  'prefix' => 'auth',
  'namespace' => 'App\Bitres\Auth\Presentation\Http\Controllers',
], function ($router) {
  $router->post('login', LoginController::class);
  $router->post('logout', LogoutController::class);
  $router->post('refresh', RefreshTokenController::class);
  $router->get('me', MeController::class);
});