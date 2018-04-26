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
    $this->assertEquals(
      md5($text->render()),
      'd4722c2f09e7673ad7899775d10523e8'
    );
  }
}