<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/ellipse_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Ellipse
 * @package DXFighter\lib
 */
class Ellipse extends Entity {
  protected $center;
  protected $endpoint;
  protected $extrusion;
  protected $ratio;
  protected $start;
  protected $end;

  /**
   * Ellipse constructor.
   * @param $center
   * @param $endpoint
   * @param $ratio
   * @param int $start
   * @param float $end
   * @param array $extrusion
   */
  function __construct($center, $endpoint, $ratio, $start = 0, $end = M_PI * 2, $extrusion = array(0, 0, 1)) {
    $this->entityType = 'ellipse';
    $this->center = $center;
    $this->endpoint = $endpoint;
    $this->ratio = $ratio;
    $this->start = $start;
    $this->end = $end;
    $this->extrusion = $extrusion;
    parent::__construct();
  }

  /**
   * Public function to move an Ellipse entity
   * @param array $move vector to move the entity with
   */
  public function move($move) {
    $this->movePoint($this->center, $move);
  }

  /**
   * Rotate the center and endpoint of the ellipsis around the given rotation center
   * @param $rotate
   * @param array $rotationCenter
   */
  public function rotate($rotate, $rotationCenter = array(0, 0, 0)) {
    $this->rotatePoint($this->center, $rotationCenter, deg2rad($rotate));
    $this->rotatePoint($this->endpoint, $rotationCenter, deg2rad($rotate));
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbEllipse');
    array_push($output, $this->point($this->center));
    array_push($output, $this->point($this->endpoint, 1));
    array_push($output, $this->point($this->extrusion, 200));
    array_push($output, 40, $this->ratio);
    array_push($output, 41, $this->start);
    array_push($output, 42, $this->end);
    return implode(PHP_EOL, $output);
  }

  public function getCenter() {
    return $this->center;
  }

  public function getEndpoint() {
    return $this->endpoint;
  }

  public function getExtrusion() {
    return $this->extrusion;
  }

  public function getRatio() {
    return $this->ratio;
  }

  public function getStart() {
    return $this->start;
  }

  public function getEnd() {
    return $this->end;
  }
}
