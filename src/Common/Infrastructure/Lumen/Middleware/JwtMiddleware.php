<?php

namespace App\Common\Infrastructure\Lumen\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
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
        return response()->unauthorized(['status' => 'Token is Invalid']);
      } else {
        return response()->unauthorized(['status' => 'Authorization Token not found']);
      }
    }
    return $next($request);
  }
}
