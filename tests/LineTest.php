<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Line;
require_once('./DXFighter.php');

final class LineTest extends TestCase {
  public function testCanCreateLineInstance(): void {
    $line = new Line(array(0,0,0),array(10,10,10));
    $this->assertInstanceOf(
      Line::class,
      $line
    );

    $id = $line->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $line->render(),
      "0\nLINE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbLine\n39\n0\n10\n0.000\n20\n0.000\n30\n0.000\n11\n10.000\n21\n10.000\n31\n10.000\n210\n0.000\n220\n0.000\n230\n1.000"
    );

    $line->rotate('90', array(5,0,0));

    $this->assertEquals(
      $line->render(),
      "0\nLINE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbLine\n39\n0\n10\n5.000\n20\n-5.000\n30\n0.000\n11\n-5.000\n21\n5.000\n31\n10.000\n210\n0.000\n220\n0.000\n230\n1.000"
    );
  }
}