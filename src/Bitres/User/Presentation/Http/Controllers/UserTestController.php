<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use Illuminate\Support\Str;
use App\Common\Presentation\Http\Controller;
use App\Bitres\User\Domain\Factories\UserFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserTestController extends Controller
{
  /**
   * @return JsonResponse
   */
  public function __invoke(): JsonResponse
  {
    $user = UserFactory::new();
    $jsonResponse = [
      'data' => [
        'control' => Str::uuid(),
        'user' => $user
      ],
    ];
    return response()->success($jsonResponse);
  }
}
