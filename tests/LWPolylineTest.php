<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\LWPolyline;
require_once('./DXFighter.php');

final class LWPolylineTest extends TestCase {
  public function testCanCreateLWPolylineInstance(): void {
    $lwpolyline = new LWPolyline();
    $this->assertInstanceOf(
      LWPolyline::class,
      $lwpolyline
    );

    $lwpolyline->setFlag(0,1);
    $lwpolyline->setColor(98);
    $lwpolyline->addPoint(array(-100,0,0));
    $lwpolyline->addPoint(array(-55,-86.6,0));
    $lwpolyline->addPoint(array(50,-86.6,0));

    $id = $lwpolyline->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $lwpolyline->render(),
      "0\nLWPOLYLINE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n98\n48\n1\n60\n0\n100\nAcDbPolyline\n90\n3\n70\n1\n10\n-100.000\n20\n0.000\n30\n0.000\n10\n-55.000\n20\n-86.600\n30\n0.000\n10\n50.000\n20\n-86.600\n30\n0.000"
    );
  }
}