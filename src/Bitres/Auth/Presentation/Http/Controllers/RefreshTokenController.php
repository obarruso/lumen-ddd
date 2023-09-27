<?php

namespace App\Bitres\Auth\Presentation\Http\Controllers;

use App\Bitres\Auth\Domain\AuthInterface;
use App\Common\Presentation\Http\Controller;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class RefreshTokenController extends Controller
{
  use WithToken;
  
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
    try {
        $token = $this->auth->refresh();
    } catch (AuthenticationException $e) {
        return response()->forbidden(['status' => $e->getMessage()]);
    }

    return $this->respondWithToken($token);
  }
}
