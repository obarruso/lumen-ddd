<?php

namespace App\Bitres\Auth\Presentation\Http\Controllers;

use App\Common\Presentation\Http\Controller;
use App\Bitres\Auth\Domain\AuthInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
  private AuthInterface $auth;

  public function __construct(AuthInterface $auth)
  {
    $this->auth = $auth;
  }

  /**
   * Get a JWT via given credentials.
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function __invoke(Request $request): JsonResponse
  {
    try {
      // $this->validate(
      //   $request,
      //   [
      //     'email' => ['required', 'email'],
      //     'password' => ['required', 'string'],
      //   ]
      // );
      $email = $request->get('email');
      $password = $request->get('password');
      $credentials = ['email' => strtolower($email), 'password' => $password];

      $token = $this->auth->login($credentials);
      return $this->respondWithToken($token);
    } catch (ValidationException $validationException) {
      return response()->error($validationException->errors());
    } catch (AuthenticationException) {
      return response()->unauthorized(['error' => 'Unauthorized']);
    }
  }

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
