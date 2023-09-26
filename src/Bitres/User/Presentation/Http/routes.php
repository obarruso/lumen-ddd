<?php

use App\Bitres\User\Presentation\Http\Controllers\CreateUserController;
use App\Bitres\User\Presentation\Http\Controllers\GetUserByIdController;
use App\Bitres\User\Presentation\Http\Controllers\UserTestController;

$router->group([
  'prefix' => 'user',
], function ($router) {
  $router->get('/fake', UserTestController::class);
  $router->post('{uuid}', CreateUserController::class);
  $router->get('{uuid}', GetUserByIdController::class);
});