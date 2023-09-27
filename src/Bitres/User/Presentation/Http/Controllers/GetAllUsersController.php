<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use App\Bitres\User\Application\UseCases\Queries\FindAllUsersQuery;
use Illuminate\Support\Str;
use App\Common\Presentation\Http\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetAllUsersController extends Controller
{
  public function __invoke(): JsonResponse
  {
    try {
      $users = (new FindAllUsersQuery())->handle();
      $jsonResponse = [
        'data' => [
          'control' => Str::uuid(),
          'users' => $users->items()
        ],
      ];
      return response()->success($jsonResponse);
    } catch (ModelNotFoundException $modelNotFoundException) {
      return response()->notFound([
        'error' => [
          'message' => 'User not found' // TODO:  Create Exception
        ]
      ]);
    }
  }
}