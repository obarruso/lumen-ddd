<?php

namespace App\Common\Infrastructure\Lumen\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    try {
      if (
        in_array($request->decodedPath(), [
          'auth/login',
          'auth/refresh',
          'login',
          'refresh'
        ])
        && $request->method() == 'POST'
      ) {
        return $next($request);
      }
      JWTAuth::parseToken()->authenticate();
    } catch (Exception $e) {
      if ($e instanceof TokenInvalidException || $e instanceof TokenExpiredException) {
        return response()->json(['status' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
      } else {
        return response()->json(['status' => 'Authorization Token not found'], Response::HTTP_UNAUTHORIZED);
      }
    }
    return $next($request);
  }
}
