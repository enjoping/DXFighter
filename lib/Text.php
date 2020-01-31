<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/text_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Text
 * @package DXFighter\lib
 */
class Text extends Entity {
  protected $thickness;
  protected $point;
  protected $height;
  protected $text;
  protected $rotation;
  protected $xscale = 1;
  protected $textStyle = 'STANDARD';
  protected $horizontalJustification = 0;
  protected $verticalJustification = 0;

  /**
   * Text constructor.
   * @param $text
   * @param $point
   * @param $height
   * @param int $rotation
   * @param int $thickness
   */
  function __construct($text, $point, $height, $rotation = 0, $thickness = 0) {
    $this->entityType = 'text';
    $this->text = $text;
    $this->point = $point;
    $this->height = $height;
    $this->rotation = $rotation;
    $this->thickness = $thickness;
    parent::__construct();
  }

  /**
   * @param $value
   */
  public function setHorizontalJustification($value) {
    $this->horizontalJustification = $value;
  }

  /**
   * @param $value
   */
  public function setVerticalJustification($value) {
    $this->verticalJustification = $value;
  }

  /**
   * Public function to move a Text entity
   * @param array $move vector to move the entity with
   */
  public function move($move) {
    $this->movePoint($this->point, $move);
  }

  /**
   * Public function to rotate a Text objet
   * @param int $rotate degree value used for the rotation
   * @param array $rotationCenter center point of the rotation
   */
  public function rotate($rotate, $rotationCenter = array(0, 0, 0)) {
    $this->rotation += $rotate;
    $this->rotatePoint($this->point, $rotationCenter, deg2rad($rotate));
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbText');
    array_push($output, 39, $this->thickness);
    array_push($output, $this->point($this->point));
    array_push($output, 40, $this->height);
    array_push($output, 1, $this->text);
    array_push($output, 50, $this->rotation);
    array_push($output, 41, $this->xscale);
    array_push($output, 7, $this->textStyle);
    array_push($output, 72, $this->horizontalJustification);
    array_push($output, 100, 'AcDbText');
    array_push($output, 73, $this->verticalJustification);
    return implode(PHP_EOL, $output);
  }
}
