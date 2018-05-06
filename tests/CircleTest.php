<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Circle;
require_once('./DXFighter.php');

final class CircleTest extends TestCase {
  public function testCanCreateCircleInstance(): void {
    $circle = new Circle(array(0,0,0),20,5,array(5,10,2));
    $this->assertInstanceOf(
      Circle::class,
      $circle
    );

    $id = $circle->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $circle->render(),
      "0\nCIRCLE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbCircle\n39\n5\n10\n0.000\n20\n0.000\n30\n0.000\n40\n20\n210\n5.000\n220\n10.000\n230\n2.000"
    );
  }
}