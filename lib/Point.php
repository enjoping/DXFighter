<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/point_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Point
 * @package DXFighter\lib
 */
class Point extends Entity {
  protected $thickness;
  protected $point;
  protected $extrusion;
  protected $angle;

  /**
   * Point constructor.
   * @param $point
   * @param int $thickness
   * @param array $extrusion
   * @param int $angle
   */
  function __construct($point, $thickness = 0, $extrusion = array(0, 0, 1), $angle = 0) {
    $this->entityType = 'point';
    $this->point = $point;
    $this->thickness = $thickness;
    $this->extrusion = $extrusion;
    $this->angle = $angle;
    parent::__construct();
  }

  /**
   * Public function to move a Point entity
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
    array_push($output, 100, 'AcDbPoint');
    array_push($output, 39, $this->thickness);
    array_push($output, $this->point($this->point));
    array_push($output, $this->point($this->extrusion, 200));
    array_push($output, 50, $this->angle);
    return implode(PHP_EOL, $output);
  }

  public function getThickness() {
    return $this->thickness;
  }

  public function getPoint() {
    return $this->point;
  }

  public function getExtrusion() {
    return $this->extrusion;
  }

  public function getAngle() {
    return $this->angle;
  }
}
