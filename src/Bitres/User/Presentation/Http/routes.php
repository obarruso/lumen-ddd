<?php

$router->group([
  'prefix' => 'user',
  'namespace' => 'App\Bitres\User\Presentation\Http\Controllers',
], function ($router) {
  $router->get('', GetAllUsersController::class);
  $router->get('{uuid}', GetUserByIdController::class);
  $router->post('{uuid}', CreateUserController::class);
  $router->patch('{uuid}', UpdateUserController::class);
  $router->delete('{uuid}', DeleteUserController::class);
});