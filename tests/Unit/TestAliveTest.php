<?php

namespace Test\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;

class TestAliveTest extends TestCase
{

  /**
   * /api/test [GET]
   */
  public function testBasic()
  {
    $this->get('/api/test');
    $this->seeStatusCode(200);
    $this->seeJsonStructure(
      [
        'data' =>
        [
          'randomString',
          'control',
        ]
      ]
    );
    $this->assertIsString('data.randomString');
    $this->assertIsString('data.control');
  }

  /**
   * /api/test/{number} [GET]
   */
  public function testBasicWithNumber()
  {
    $number = rand(2,50);
    $this->get('/api/test/' . $number);
    $this->seeStatusCode(200);
    $this->seeJsonStructure(
      [
        'data' =>
        [
          'randomString',
          'control',
        ]
      ]
    );
    $this->assertIsString('data.randomString');
    $this->assertIsString('data.control');
  }

  /**
   * /api/test/{string} [GET]
   */
  public function testBasicWithString()
  {
    $string = Str::random();
    $this->get('/api/test/' . $string);
    $this->seeStatusCode(400);
  }

  /**
   * /api/test/token [GET]
   */
  public function testWithLogin()
  {
    // TODO
    $this->assertCount(1,array(1));
  }
}
