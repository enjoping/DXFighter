<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/lwpolyline_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class LWPolyline
 * @package DXFighter\lib
 */
class LWPolyline extends Entity {
  protected $points = array();
  protected $bulges = array();
  protected $dimension;

  /**
   * LWPolyline constructor.
   * @param int $dimension
   */
  function __construct($dimension = 2) {
    $this->entityType = 'lwpolyline';
    $this->flags = array_fill(0, 7, 0);
    $this->dimension = $dimension;
    parent::__construct();
  }

  /**
   * Add a point to the LWPolyline
   * @param array $point
   */
  public function addPoint($point, $bulge = 0) {
    $this->points[] = $point;
    $this->bulges[] = $bulge;
    return $this;
  }

  public function getPoints() {
    return $this->points;
  }

  public function getBulges() {
    return $this->bulges;
  }

  /**
   * Public function to move a Polyline entity
   * @param array $move vector to move the entity with
   */
  public function move($move) {
    foreach ($this->points as &$point) {
      $this->movePoint($point, $move);
    }
  }

  /**
   * Public function to rotate all points of a polyline
   * @param int $rotate degree value used for the rotation
   * @param array $rotationCenter center point of the rotation
   */
  public function rotate($rotate, $rotationCenter = array(0, 0, 0)) {
    foreach ($this->points as &$point) {
      $this->rotatePoint($point, $rotationCenter, deg2rad($rotate));
    }
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbPolyline');
    array_push($output, 90, count($this->points));
    array_push($output, 70, $this->flagsToString());

    foreach ($this->points as $i => $point) {
      array_push($output, $this->point($point));
      array_push($output, 42, $this->bulges[$i]);
    }

    return implode(PHP_EOL, $output);
  }
}
