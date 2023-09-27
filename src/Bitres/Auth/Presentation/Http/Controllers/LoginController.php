<?php

namespace App\Bitres\Auth\Presentation\Http\Controllers;

use App\Bitres\Auth\Domain\AuthInterface;
use App\Common\Presentation\Http\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
  use WithToken;
  
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
}
