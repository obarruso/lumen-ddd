<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Application\UseCases\Commands\UpdateUserCommand;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use App\Common\Domain\Exceptions\UnauthorizedUserException;
use App\Common\Presentation\Http\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserController extends Controller
{
  public function __invoke(Request $request): Response
  {
    try {
      $params = $request->all();
      $userData = UserMapper::fromRequest($request, $request->uuid);
      $password = new Password($request->input('password'), $request->input('password_confirmation'));
      (new UpdateUserCommand($userData, $password))->execute();
    } catch (\DomainException $domainException) {
      return response()->json(
        [
          'error' => [
            'message' => $domainException->getMessage()
          ]
        ],
        Response::HTTP_UNPROCESSABLE_ENTITY
      );
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

    return response()->noContent();
  }
}
