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

  function __construct($start, $end, $thickness = 0, $extrusion = array(0,0,1)) {
    $this->entityType = 'line';
    $this->start = $start;
    $this->end = $end;
    $this->thickness = $thickness;
    $this->extrusion = $extrusion;
    parent::__construct();
  }

  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbLine');
    array_push($output, 39, $this->thickness);
    array_push($output, $this->point($this->start));
    array_push($output, $this->point($this->end, 1));
    array_push($output, $this->point($this->extrusion, 200));
    return implode($output, PHP_EOL);
  }
}
