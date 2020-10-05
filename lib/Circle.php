<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/circle_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Circle
 * @package DXFighter\lib
 */
class Circle extends Entity {
  protected $thickness;
  protected $point;
  protected $radius;
  protected $extrusion;

  /**
   * Circle constructor.
   * @param $point
   * @param $radius
   * @param int $thickness
   * @param array $extrusion
   */
  function __construct($point, $radius, $thickness = 0, $extrusion = array(0, 0, 1)) {
    $this->entityType = 'circle';
    $this->point = $point;
    $this->radius = $radius;
    $this->thickness = $thickness;
    $this->extrusion = $extrusion;
    parent::__construct();
  }

  /**
   * Public function to move a Circle entity
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
    array_push($output, 100, 'AcDbCircle');
    array_push($output, 39, $this->thickness);
    array_push($output, $this->point($this->point));
    array_push($output, 40, $this->radius);
    array_push($output, $this->point($this->extrusion, 200));
    return implode(PHP_EOL, $output);
  }

  public function getThickness() {
    return $this->thickness;
  }

  public function getPoint() {
    return $this->point;
  }

  public function getRadius() {
    return $this->radius;
  }

  public function getExtrusion() {
    return $this->extrusion;
  }
}
