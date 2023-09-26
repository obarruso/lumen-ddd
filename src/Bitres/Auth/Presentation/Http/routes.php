<?php

use App\Bitres\Auth\Presentation\Http\Controllers\LoginController;
use App\Bitres\User\Presentation\Http\Controllers\UserTestController;

$router->group([
  'prefix' => 'auth',
], function ($router) {
    $router->post('/login', LoginController::class);
});