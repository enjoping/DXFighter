<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/vertex_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Vertex
 * @package DXFighter\lib
 */
class Vertex extends Entity {
  protected $dimension;
  protected $point;

  function __construct($point, $dimension, $pointer, $layer) {
    $this->entityType = 'vertex';
    $this->point = $point;
    $this->dimension = $dimension;
    $this->pointer = $pointer;
    $this->flags = array_fill(0, 7, 0);
    parent::__construct();
  }

  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbVertex');
    array_push($output, 100, $this->dimension == 2 ? 'AcDb2dVertex' : 'AcDb3dPolylineVertex');
    array_push($output, $this->point($this->point));
    array_push($output, 70, $this->flagsToString());
    return implode($output, PHP_EOL);
  }
}
