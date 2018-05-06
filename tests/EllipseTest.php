<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Ellipse;
require_once('./DXFighter.php');

final class EllipseTest extends TestCase {
  public function testCanCreateEllipseInstance(): void {
    $ellipse = new Ellipse(array(0,-50,0),array(0,12,0),0.5,M_PI/2,M_PI,array(5,5,2));
    $this->assertInstanceOf(
      Ellipse::class,
      $ellipse
    );

    $id = $ellipse->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $ellipse->render(),
      "0\nELLIPSE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbEllipse\n10\n0.000\n20\n-50.000\n30\n0.000\n11\n0.000\n21\n12.000\n31\n0.000\n210\n5.000\n220\n5.000\n230\n2.000\n40\n0.5\n41\n1.5707963267949\n42\n3.1415926535898"
    );
  }
}