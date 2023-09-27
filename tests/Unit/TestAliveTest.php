<?php

namespace Test\Unit;

use Tests\TestCase;

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
   * /api/test/token [GET]
   */
  public function testWithLogin()
  {
    // TODO
  }
}
