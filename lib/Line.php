<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/line_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Line
 * @package DXFighter\lib
 */
class Line extends Entity {
  protected $thickness;
  protected $start;
  protected $end;
  protected $extrusion;

  /**
   * Line constructor.
   * @param $start
   * @param $end
   * @param int $thickness
   * @param array $extrusion
   */
  function __construct($start, $end, $thickness = 0, $extrusion = array(0, 0, 1)) {
    $this->entityType = 'line';
    $this->start = $start;
    $this->end = $end;
    $this->thickness = $thickness;
    $this->extrusion = $extrusion;
    parent::__construct();
  }

  /**
   * Public function to move a Line entity
   * @param array $move vector to move the entity with
   */
  public function move($move) {
    $this->movePoint($this->start, $move);
    $this->movePoint($this->end, $move);
  }

  /**
   * Rotate the begin and end of the line around the given rotation center
   * @param $rotate
   * @param array $rotationCenter
   */
  public function rotate($rotate, $rotationCenter = array(0, 0, 0)) {
    $this->rotatePoint($this->start, $rotationCenter, deg2rad($rotate));
    $this->rotatePoint($this->end, $rotationCenter, deg2rad($rotate));
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbLine');
    array_push($output, 39, $this->thickness);
    array_push($output, $this->point($this->start));
    array_push($output, $this->point($this->end, 1));
    array_push($output, $this->point($this->extrusion, 200));
    return implode(PHP_EOL, $output);
  }

  public function getThickness() {
    return $this->thickness;
  }

  public function getStart() {
    return $this->start;
  }

  public function getEnd() {
    return $this->end;
  }

  public function getExtrusion() {
    return $this->extrusion;
  }
}
