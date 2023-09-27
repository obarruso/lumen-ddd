<?php

namespace App\Bitres\Auth\Presentation\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

trait WithToken
{
  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return JsonResponse
   */
  protected function respondWithToken(string $token): JsonResponse
  {
    return response()->success([
      'accessToken' => $token,
      'token_type' => 'bearer',
      'expires_in' => config('jwt.ttl') * 1,
    ]);
  }
}