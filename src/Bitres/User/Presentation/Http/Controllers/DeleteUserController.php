<?php

namespace App\Bitres\User\Presentation\Http\Controllers;

use App\Bitres\User\Application\UseCases\Commands\DestroyUserCommand;
use App\Common\Domain\Exceptions\UnauthorizedUserException;
use App\Common\Presentation\Http\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserController extends Controller
{
  public function __invoke($uuid = null): JsonResponse
  {
    try {
      (new DestroyUserCommand($uuid))->execute();
      return response()->noContent(null);
    } catch (UnauthorizedUserException $e) {
      return response()->unauthorized([
        'error' => [
          'message' => $e->getMessage()
        ]
      ]);
    } catch (ModelNotFoundException $modelNotFoundException) {
      return response()->notFound([
        'error' => [
          'message' => 'User not found' // TODO:  Create Exception
        ]
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'error' => [
          'message' => 'Internal error'
        ]
      ], 500);
    }
  }
}
