<?php

$router->group([
  'prefix' => 'test',
  'namespace' => 'App\Test\Presentation\Http\Controllers',
], function ($router) {
  $router->get('', ['uses' => 'TestAliveController']);
  $router->get('{i}', ['uses' => 'TestAliveController']);
});
