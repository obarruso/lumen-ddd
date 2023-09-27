<?php

// use App\Bitres\Auth\Presentation\Http\Controllers\LoginController;
// use App\Bitres\Auth\Presentation\Http\Controllers\LogoutController;
// use App\Bitres\Auth\Presentation\Http\Controllers\RefreshTokenController;
// use App\Bitres\Auth\Presentation\Http\Controllers\MeController;

$router->group([
  'prefix' => 'auth',
  'namespace' => 'App\Bitres\Auth\Presentation\Http\Controllers',
], function ($router) {
  $router->post('login', LoginController::class);
  $router->post('logout', LogoutController::class);
  $router->post('refresh', RefreshTokenController::class);
  $router->get('me', MeController::class);
});