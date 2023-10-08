<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use App\Common\Domain\Exceptions\UnauthorizedUserException;
use Illuminate\Support\Str;
use App\Common\Presentation\Http\Controller;
use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Application\UseCases\Commands\StoreUserCommand;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
  public function __invoke(Request $request): JsonResponse
  {
    try {
      $userData = UserMapper::fromRequest($request, $request->uuid);
      $password = new Password($request->input('password'), $request->input('password_confirmation'));
      $user = (new StoreUserCommand($userData, $password))->execute();
    } catch (\DomainException $domainException) {
      return response()->json([
        'error' => [
          'message' => $domainException->getMessage()
        ]
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    } catch (UnauthorizedUserException $e) {
      return response()->unauthorized([
        'error' => [
          'message' => $e->getMessage()
        ]
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'error' => [
          'message' => 'Internal error'
        ]
      ], 500);
    }

    $jsonResponse = [
      'data' => [
        'control' => Str::uuid(),
        'user' => $user
      ],
    ];
    return response()->created($jsonResponse);
  }
}
