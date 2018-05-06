<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Point;
require_once('./DXFighter.php');

final class PointTest extends TestCase {
  public function testCanCreatePointInstance(): void {
    $point = new Point(array(10,10,0),2,array(5,5,2),2);
    $this->assertInstanceOf(
      Point::class,
      $point
    );

    $id = $point->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $point->render(),
      "0\nPOINT\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbPoint\n39\n2\n10\n10.000\n20\n10.000\n30\n0.000\n210\n5.000\n220\n5.000\n230\n2.000\n50\n2"
    );
  }
}