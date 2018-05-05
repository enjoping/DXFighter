<?php

use PHPUnit\Framework\TestCase;
use DXFighter\lib\Text;
require_once('./DXFighter.php');

final class TextTest extends TestCase {
  public function testCanCreateTextInstance(): void {
    $text = 'testText';
    $point = array(-10,90,0);
    $height = 50;
    $rotation = 2;
    $thickness = 2;

    $text = new Text($text, $point, $height, $rotation, $thickness);
    $this->assertInstanceOf(
      Text::class,
      $text
    );

    $id = $text->getHandle();
    $this->assertInternalType("int", hexdec($id));
    $this->assertGreaterThan(0, hexdec($id));

    $this->assertEquals(
      $text->render(),
      "0\nTEXT\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbText\n39\n2\n10\n-10.000\n20\n90.000\n30\n0.000\n40\n50\n1\ntestText\n50\n2\n41\n1\n7\nSTANDARD\n72\n0\n100\nAcDbText\n73\n0"
    );

    $text->setHorizontalJustification(1);
    $text->setVerticalJustification(2);

    $this->assertEquals(
      $text->render(),
      "0\nTEXT\n5\n".$id."\n330\n0\n100\nAcDbEntity\n67\n0\n8\n0\n6\nBYLAYER\n62\n256\n48\n1\n60\n0\n100\nAcDbText\n39\n2\n10\n-10.000\n20\n90.000\n30\n0.000\n40\n50\n1\ntestText\n50\n2\n41\n1\n7\nSTANDARD\n72\n1\n100\nAcDbText\n73\n2"
    );
  }
}