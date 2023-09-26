<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use Illuminate\Support\Str;
use App\Common\Presentation\Http\Controller;
use App\Bitres\User\Application\UseCases\Queries\FindUserByIdQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetUserByIdController extends Controller
{
  public function __invoke($uuid = null): JsonResponse
  {
    try {
      $user = (new FindUserByIdQuery($uuid))->handle();
      $jsonResponse = [
        'data' => [
          'control' => Str::uuid(),
          'user' => $user
        ],
      ];
      return response()->success($jsonResponse);
    } catch (ModelNotFoundException $modelNotFoundException) {
      return response()->notFound('User not found');
    }
  }
}