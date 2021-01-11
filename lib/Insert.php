<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 13.02.20
 * Time: 20:57
 *
 * Documentation https://www.autodesk.com/techpubs/autocad/acad2000/dxf/insert_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Circle
 * @package DXFighter\lib
 */
class Insert extends Entity {
  protected $blockName;
  protected $point;
  protected $scale;
  protected $rotation;

  /**
   * Insert constructor.
   *
   * @param $blockName
   * @param float[] $point
   * @param float[] $scale The X, Y and Z scale factors.
   * @param float $rotation
   */
  function __construct( $blockName, $point = [0, 0, 0], $scale = [1, 1, 1], $rotation = 0) {
    $this->entityType = 'insert';
    $this->blockName       = $blockName;
    $this->point      = $point;
    $this->scale      = $scale;
    $this->rotation   = $rotation;
    parent::__construct();
  }

  /**
   * Public function to move an Insert entity
   * @param array $move vector to move the entity with
   */
  public function move($move) {
    $this->movePoint($this->point, $move);
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbBlockReference');
    array_push($output, 2, strtoupper($this->blockName));
    array_push($output, $this->point($this->point));
    array_push($output, 41, $this->scale[0]);
    array_push($output, 42, $this->scale[1]);
    array_push($output, 43, $this->scale[2]);
    array_push($output, 50, $this->rotation);
    return implode(PHP_EOL, $output);
  }

  public function getBlockName() {
    return $this->blockName;
  }

  public function getPoint() {
    return $this->point;
  }

  public function getScale() {
    return $this->scale;
  }

  public function getRotation() {
    return $this->rotation;
  }
}
