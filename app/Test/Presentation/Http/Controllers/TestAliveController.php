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

    $str = Str::random($i);
    $jsonResponse = [
      'data' => [
        'randomString' => $str,
      ],
    ];
    return response()->json($jsonResponse, 200);
  }
}
