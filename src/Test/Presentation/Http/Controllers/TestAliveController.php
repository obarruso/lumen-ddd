<?php

namespace App\Test\Presentation\Http\Controllers;

use Illuminate\Support\Str;
use App\Common\Presentation\Http\Controller;

class TestAliveController extends Controller
{
  public function __invoke($i = null)
  {
    if (!$i) {
      $i = 10;
    }
    if (!is_numeric($i)) {
      return response()->error(['error' => 'Not a number']);
    }

    $str = Str::random($i);
    $jsonResponse = [
      'data' => [
        'control' => Str::uuid(),
        'randomString' => $str,
      ],
    ];
    return response()->success($jsonResponse);
  }
}
