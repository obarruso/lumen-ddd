<?php

namespace App\Bitres\Auth\Presentation\Http\Controllers;

use App\Bitres\Auth\Domain\AuthInterface;
use App\Common\Presentation\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogoutController extends Controller
{
  private AuthInterface $auth;

  public function __construct(AuthInterface $auth)
  {
    $this->auth = $auth;
  }

  /**
   * Get the authenticated UserEloquentModel.
   *
   * @return JsonResponse
   */
  public function __invoke(): JsonResponse
  {
    $this->auth->logout();
    return response()->success(['message' => 'Successfully logged out']);
  }
}
