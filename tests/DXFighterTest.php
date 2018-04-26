<?php

use PHPUnit\Framework\TestCase;
use DXFighter\DXFighter;
require_once('./DXFighter.php');

final class DXFighterTest extends TestCase {
  public function testCanCreateDxfighterInstance(): void {
    $dxf = new DXFighter();
    $this->assertInstanceOf(
      DXFighter::class,
      $dxf
    );
    $this->assertEquals(
      $dxf->toArray(),
      [
        'HEADER' => [],
        'CLASSES' => [],
        'TABLES' => [],
        'BLOCKS' => [],
        'ENTITIES' => [],
        'OBJECTS' => [],
        'THUMBNAILIMAGE' => []
      ]
    );
    $this->assertEquals(
      md5($dxf->toString(FALSE)),
      '1da61b24a6c9eca4f63ed52d21381411'
    );
  }
}