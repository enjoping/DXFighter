<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 13.02.20
 * Time: 16:15
 *
 * Documentation https://www.autodesk.com/techpubs/autocad/acad2000/dxf/spline_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Spline
 * @package DXFighter\lib
 */
class Spline extends Entity {
  protected $base = [0, 0, 0];
  protected $start = [0, 0, 0];
  protected $end = [0, 0, 0];
  protected $points = [];
  protected $knots = [];
  protected $degree = 1;

  /**
   * Spline constructor.
   * @param int $degree
   * @param array $base
   * @param array $start
   * @param array $end
   */
  function __construct($degree = 1, $base = [0, 0, 0], $start = [0, 0, 0], $end = [0, 0, 0]) {
    $this->entityType = 'spline';
    $this->flags = array_fill(0, 7, 0);
    $this->degree = $degree;
    $this->base = $base;
    $this->start = $start;
    $this->end = $end;
    parent::__construct();
  }

  /**
   * Public function to add a new point to the polyline
   * @param array $point
   */
  public function addPoint($point) {
    $this->points[] = [$point[0], $point[1], $point[2]];
    return $this;
  }

  /**
   * Public function to add a new point to the polyline
   * @param int $value
   */
  public function addKnot($value) {
    $this->knots[] = $value;
    return $this;
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbSpline');
    array_push($output, $this->point($this->base, 200));
    array_push($output, 70, $this->flagsToString());
    array_push($output, 71, $this->degree);
    array_push($output, 72, sizeof($this->knots));
    array_push($output, 73, sizeof($this->points));
    array_push($output, 74, 0);
    array_push($output, 42, '0.0000001');
    array_push($output, 43, '0.0000001');
    array_push($output, 44, '0.0000000001');
    array_push($output, $this->point($this->start, 2));
    array_push($output, $this->point($this->end, 3));

    foreach ($this->knots as $knot) {
      array_push($output, 40, $knot);
    }
    foreach ($this->points as $point) {
      array_push($output, $this->point($point));
    }

    return implode(PHP_EOL, $output);
  }

  public function getBase() {
    return $this->base;
  }

  public function getStart() {
    return $this->start;
  }

  public function getEnd() {
    return $this->end;
  }

  public function getPoints() {
    return $this->points;
  }

  public function getKnots() {
    return $this->knots;
  }

  public function getDegree() {
    return $this->degree;
  }
}
