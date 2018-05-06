<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Polyline;
require_once('./DXFighter.php');

final class PolylineTest extends TestCase {
  public function testCanCreatePolylineInstance(): void {
    $polyline = new Polyline();
    $this->assertInstanceOf(
      Polyline::class,
      $polyline
    );

    $polyline->setFlag(0,1);
    $polyline->setColor(98);
    $polyline->addPoint(array(-100,0,0));
    $polyline->addPoint(array(-55,-86.6,0));
    $polyline->addPoint(array(50,-86.6,0));

    $id = $polyline->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $polyline->render(),
      "0\nPOLYLINE\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n98\n48\n1\n60\n0\n100\nAcDb2dPolyline\n10\n0.000\n20\n0.000\n30\n0.000\n70\n1\n0\nVERTEX\n5\n".($id+1)."\n330\n".$id."\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbVertex\n100\nAcDb2dVertex\n10\n-100.000\n20\n0.000\n30\n0.000\n42\n0\n70\n0\n0\nVERTEX\n5\n".($id+2)."\n330\n".$id."\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbVertex\n100\nAcDb2dVertex\n10\n-55.000\n20\n-86.600\n30\n0.000\n42\n0\n70\n0\n0\nVERTEX\n5\n".($id+3)."\n330\n".$id."\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbVertex\n100\nAcDb2dVertex\n10\n50.000\n20\n-86.600\n30\n0.000\n42\n0\n70\n0\n0\nSEQEND\n5\n".($id+4)."\n330\n".$id."\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0"
    );
  }
}