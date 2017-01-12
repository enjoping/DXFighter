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
  protected $thickness;
  protected $extrusion;
  protected $points = array();
  protected $dimension;
  protected $seqend;

  function __construct($dimension = 2) {
    $this->entityType = 'lwpolyline';
    $this->flags = array_fill(0, 7, 0);
    $this->dimension = $dimension;
    parent::__construct();
  }

  public function addPoint($point) {
    $this->points[] = $point;
  }

  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbPolyline');
    array_push($output, 90, sizeof($this->points));
    array_push($output, 70, $this->flagsToString());

    foreach($this->points as $point) {
      array_push($output, $this->point($point));
    }

    return implode($output, PHP_EOL);
  }
}
